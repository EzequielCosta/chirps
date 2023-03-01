<script setup>

    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import InputError from "@/Components/InputError.vue";
    import PrimaryButton from "@/Components/PrimaryButton.vue";
    import Chirp from "@/Components/Chirp.vue";
    import {useForm, Head} from "@inertiajs/vue3";
    import {computed, onMounted, ref} from "vue";

    const props = defineProps(["chirpsList"]);
    const chirps = ref(props.chirpsList);

    //const chirpsRevert = computed(() => [...chirps.value.reverse()]);


    onMounted(() => {

        Echo.join(`room`)
            .here((users) => {
                console.log(users);
            })
            .joining((user) => {
                console.log(user);
            })
            .leaving((user) => {
                console.log(user);
            })
            .error((error) => {
                console.log(error);
            })
            .listen('NewMessage',  async (e) => {

                chirps.value = [e.data,...chirps.value];
                //chirps.value.reverse();
            })
    });




    const form = useForm({
        'message' : '',
    });

</script>

<template>
    <Head title="Chirps"></Head>

    <AuthenticatedLayout>
        <div class="sm:max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('chirps.store'),{ onSuccess: () => form.reset() })">
                <textarea
                    v-model="form.message"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300
                     focus:ring focus:ring-indigo-200 focus:ring-opactity-50
                      rounded-md shadow-sm">
                </textarea>

                <InputError :message="form.errors.message" class="mt-2"></InputError>
                <PrimaryButton class="mt-4">Chirp</PrimaryButton>
            </form>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Chirp
                    class="mb-3 bg-gray-100"
                    v-for="chirp in chirps"
                    :key="chirp.id"
                    :chirp="chirp"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
