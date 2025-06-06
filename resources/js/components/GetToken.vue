<script setup lang="ts">
    import axios from 'axios';
    import { ref } from 'vue';

    const apiResponse = ref('');

    interface Props {
        user: object;
    }

    const props = withDefaults(defineProps<Props>(), {
        user: {},
    });

    const accessTokenURLParams = new URLSearchParams({
        'grant_type': 'authorization_code',
        'client_id': '1000.7DBABT5NN8EJYMLJABQVIMHIUGHIGT',
        'client_secret': 'b04db67f267530f878abf27024659d73f5911422e7',
        'redirect_uri': 'http://127.0.0.1:8000/oauthredirect',
        'code': props.user.user.api_token ? props.user.user.api_token.authorization_code : null
    });

    const params = new URLSearchParams({
           response_type: 'code',
           client_id: '1000.7DBABT5NN8EJYMLJABQVIMHIUGHIGT',
           redirect_uri: 'http://127.0.0.1:8000/oauthredirect',
           scope: 'ZohoCRM.modules.ALL',
           access_type: 'offline',
           prompt: 'consent'
   });

   const authUrl = `https://accounts.zoho.com/oauth/v2/auth?${params.toString()}`;

    function saveToken() {
        axios.post('/access_token', {
            apiResponse: apiResponse.value
        }).then((response) => {
            apiResponse.value = '';
        });
    }
</script>

<template>
    <div class="mb-8 space-y-0.5">
         <a :href="authUrl"
            class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition"
         >
           <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition" @click="getToken">
               1. Get Authorization Code
           </button>
       </a>

        <p class="mb-2">
            <form :action="`http://accounts.zoho.eu/oauth/v2/token?${accessTokenURLParams.toString()}`" method="post">
                <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    2. Get Access & Refresh Token
                </button>           
            </form>
        </p> 

        <div>
            <p>Copy the reponse you received and paste it in the field below:</p>

            <textarea name="response" id="response" cols="30" rows="10" class="block border border-gray-300 w-full" v-model="apiResponse"></textarea>

            <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition" @click="saveToken">
                3. Save tokens
            </button>   
        </div>
    </div>
</template>