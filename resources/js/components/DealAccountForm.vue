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
        stage: ''
    });

    const account = ref({
        name: '',
        website: '',
        phone: ''
    });

    function submitForm() {
        const payload = {
            deal: deal.value,
            account: account.value
        };

        axios.post('/deal', payload)
            .then((response) => {
                deal.value = { name: '', stage: '' };
                account.value = { name: '', website: '', phone: '' };
            });
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
                            <input v-model="deal.name" id="dealName" type="text" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>

                        <div>
                            <label for="dealStage" class="block text-sm font-medium text-gray-700">Deal Stage</label>
                            <select v-model="deal.stage" id="dealStage" type="text" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option v-for="stage in props.deal_stages.deal_stages" :value="stage.id">{{ stage.display_value }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Account Section -->
                <div class="ml-4 w-1/2">
                    <h2 class="text-xl font-semibold mb-4">Account Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="accountName" class="block text-sm font-medium text-gray-700">Account Name</label>
                            <input v-model="account.name" id="accountName" type="text" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>

                        <div>
                            <label for="accountWebsite" class="block text-sm font-medium text-gray-700">Website</label>
                            <input v-model="account.website" id="accountWebsite" type="url" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                        </div>

                        <div>
                            <label for="accountPhone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input v-model="account.phone" id="accountPhone" type="tel" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
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
        </form>
    </div>
</template>