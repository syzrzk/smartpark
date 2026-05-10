<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <style>
        .profile-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
            transition: all 0.3s;
            margin-bottom: 24px;
        }

        .dark .profile-card {
            background: #1e293b;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            border: 1px solid #334155;
        }

        .profile-card-header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            padding: 20px 24px;
            color: white;
        }

        .dark .profile-card-header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-bottom: 1px solid #334155;
        }

        .profile-card-header h2 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: white !important;
        }

        .profile-card-header p {
            font-size: 13px;
            margin-top: 4px;
            margin-bottom: 0;
            opacity: 0.8;
            color: white !important;
        }
        
        .profile-card-body {
            padding: 24px;
        }

        /* Override Breeze component styles for dark mode */
        .dark .profile-card-body input[type="text"],
        .dark .profile-card-body input[type="email"],
        .dark .profile-card-body input[type="password"] {
            background-color: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }
        
        .dark .profile-card-body input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .dark .profile-card-body label {
            color: #cbd5e1;
        }

        .dark .profile-card-body header h2 {
            display: none; /* Hide default header since we use custom header */
        }
        .dark .profile-card-body header p {
            display: none; /* Hide default sub since we use custom header */
        }
        .profile-card-body header {
            display: none; /* Hide default header completely */
        }

        /* Make Save Buttons Green */
        .profile-card-body button[type="submit"]:not(.bg-red-600) {
            background-color: #10b981 !important;
            color: white !important;
            border-color: #10b981 !important;
        }
        .profile-card-body button[type="submit"]:not(.bg-red-600):hover {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Profile Information Card --}}
            <div class="profile-card">
                <div class="profile-card-header">
                    <h2><i class="fas fa-user-circle me-2"></i>Informasi Profil</h2>
                    <p>Perbarui informasi akun profil Anda dan alamat email.</p>
                </div>
                <div class="profile-card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Update Password Card --}}
            <div class="profile-card">
                <div class="profile-card-header" style="background: linear-gradient(135deg, #4338ca, #6366f1);">
                    <h2><i class="fas fa-lock me-2"></i>Perbarui Password</h2>
                    <p>Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                </div>
                <div class="profile-card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Delete Account Card --}}
            <div class="profile-card border-red-500">
                <div class="profile-card-header" style="background: linear-gradient(135deg, #991b1b, #ef4444);">
                    <h2><i class="fas fa-exclamation-triangle me-2"></i>Hapus Akun</h2>
                    <p>Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
                </div>
                <div class="profile-card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
