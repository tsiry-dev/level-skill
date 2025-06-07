<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const form = useForm({
    old_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.security.update'), {
        onSuccess: () => {
            toast("Mot de passe modifié avec succès", {
                "theme": "colored",
                "type": "success",
                "autoClose": 3000,
                "dangerouslyHTMLString": true
            });

        setTimeout(() => {
             window.location.href = route('login');
        }, 2500);


        },
        preserveState: true,
    });
};

</script>

<template>
  <Head title="Sécurité" />

  <h1>Modifier le mot de passe</h1>


  <div class="max-w-[40%] mt-5">
      <form @submit.prevent="submit">
        <div>
          <label class="text-sm" for="old_password">Ancien mot de passe</label>
          <input
          v-model="form.old_password"
            type="password"
            name="old_password"
            class="input"
            id="old_password"
            placeholder="Mot de passe"
          />
          <span class="text-red-500 text-sm" v-if="form.errors.old_password">{{ form.errors.old_password }}</span>
        </div>

        <div>
          <label class="text-sm" for="new_password">Nouveau mot de passe</label>
          <input
           v-model="form.password"
            type="password"
            name="new_password"
            class="input"
            id="new_password"
            placeholder="Mot de passe"
          />
          <span class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</span>
        </div>

        <div>
          <label class="text-sm" for="new_password_confirmation">Confirmer le Nouveau mot de passe</label>
          <input
          v-model="form.password_confirmation"
            type="password"
            name="new_password_confirmation"
            class="input"
            id="new_password_confirmation"
            placeholder="Confirmation du mot de passe"
          />
          <span class="text-red-500 text-sm" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</span>
        </div>

        <div class="mt-5">
          <button type="submit" class="btn btn-gradient btn-success">Modifier</button>
        </div>
      </form>
  </div>

</template>

<style scoped>
</style>
