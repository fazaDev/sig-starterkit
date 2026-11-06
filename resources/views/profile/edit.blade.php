@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    @php
        $profileErrors = $errors->getBag('updateProfileInformation');
        $passwordErrors = $errors->getBag('updatePassword');
    @endphp

    <x-page-header title="Profil Saya" description="Perbarui informasi akun dan password Anda." />

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <header class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Informasi Profil</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui nama dan alamat email akun Anda.</p>
            </header>

            <form method="POST" action="{{ route('user-profile-information.update') }}" class="space-y-5 p-5">
                @csrf
                @method('PUT')

                <div>
                    <x-label for="name">Nama</x-label>
                    <x-input name="name" :value="old('name', $user->name)" required autocomplete="name" />
                    <x-input-error :messages="$profileErrors->get('name')" />
                </div>

                <div>
                    <x-label for="email">Email</x-label>
                    <x-input name="email" type="email" :value="old('email', $user->email)" required autocomplete="email" />
                    <x-input-error :messages="$profileErrors->get('email')" />
                </div>

                <x-primary-button>Simpan Profil</x-primary-button>
            </form>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <header class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Ubah Password</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gunakan password yang panjang dan sulit ditebak.</p>
            </header>

            <form method="POST" action="{{ route('user-password.update') }}" class="space-y-5 p-5">
                @csrf
                @method('PUT')

                <div>
                    <x-label for="current_password">Password Saat Ini</x-label>
                    <x-input name="current_password" type="password" required autocomplete="current-password" />
                    <x-input-error :messages="$passwordErrors->get('current_password')" />
                </div>

                <div>
                    <x-label for="password">Password Baru</x-label>
                    <x-input name="password" type="password" required autocomplete="new-password" />
                    <x-input-error :messages="$passwordErrors->get('password')" />
                </div>

                <div>
                    <x-label for="password_confirmation">Konfirmasi Password Baru</x-label>
                    <x-input name="password_confirmation" type="password" required autocomplete="new-password" />
                    <x-input-error :messages="$passwordErrors->get('password_confirmation')" />
                </div>

                <x-primary-button>Ubah Password</x-primary-button>
            </form>
        </section>
    </div>
@endsection
