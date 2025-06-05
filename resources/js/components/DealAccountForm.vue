<script setup lang="ts">
    import axios from 'axios';
    import { ref } from 'vue';

    interface Props {
        user: object,
        deal_stages: object
    }

    const props = withDefaults(defineProps<Props>(), {
        user: {},
    });

    const deal = ref({
        name: '',
        stage: '',
        closing_date: ''
    });

    const account = ref({
        name: '',
        website: '',
        phone: ''
    });

    const errors = ref([]);

    function submitForm() {
        const payload = {
            deal: deal.value,
            account: account.value
        };

        axios.post('/deal', payload)
            .then((response) => {
                console.log(response);
                deal.value = { name: '', stage: '' };
                account.value = { name: '', website: '', phone: '' };
            }).catch((err) => errors.value = err.response.data.errors ?? err.response.data );
    }

</script>

<template>
    <div>
        <h2 class="text-xl font-semibold tracking-tight text-center">Create Deal and Account</h2>

        <form @submit.prevent="submitForm" class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
            <!-- Deal Section -->
            <div class="flex">
                <div class="w-1/2">
                    <h2 class="text-xl font-semibold mb-4">Deal Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="dealName" class="block text-sm font-medium text-gray-700">Deal Name</label>
                            <input v-model="deal.name" id="dealName" type="text" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            <p class="mt-1 text-red-500">{{ errors['deal.name'] && errors['deal.name'][0] }}</p>
                        </div>

                        <div>
                            <label for="dealStage" class="block text-sm font-medium text-gray-700">Deal Stage</label>
                            <select v-model="deal.stage" id="dealStage" type="text" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option v-for="stage in props.deal_stages.deal_stages" :value="stage.id">{{ stage.display_value }}</option>
                            </select>
                            <p class="mt-1 text-red-500">{{ errors['deal.stage'] && errors['deal.stage'][0] }}</p>
                        </div>

                        <div>
                            <label for="closingDate" class="block text-sm font-medium text-gray-700">Closing Date</label>
                            <input v-model="deal.closing_date" placeholder="YYYY-MM-DD" id="closingDate" type="text" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            <p class="mt-1 text-red-500">{{ errors['deal.closing_date'] && errors['deal.closing_date'][0] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Section -->
                <div class="ml-4 w-1/2">
                    <h2 class="text-xl font-semibold mb-4">Account Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="accountName" class="block text-sm font-medium text-gray-700">Account Name</label>
                            <input v-model="account.name" id="accountName" type="text" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            <p class="mt-1 text-red-500">{{ errors['account.name'] && errors['account.name'][0] }}</p>
                        </div>

                        <div>
                            <label for="accountWebsite" class="block text-sm font-medium text-gray-700">Website</label>
                            <input v-model="account.website" id="accountWebsite" type="url" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            <p class="mt-1 text-red-500">{{ errors['account.website'] && errors['account.website'][0] }}</p>
                        </div>

                        <div>
                            <label for="accountPhone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input v-model="account.phone" id="accountPhone" type="tel" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            <p class="mt-1 text-red-500">{{ errors['account.phone'] && errors['account.phone'][0] }}</p>
                        </div>
                    </div>
                </div>                
            </div>


            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                    Submit
                </button>
            </div>

            <div class="bg-red-200">
                {{ errors.message && errors.message }}
            </div>
        </form>
    </div>
</template>