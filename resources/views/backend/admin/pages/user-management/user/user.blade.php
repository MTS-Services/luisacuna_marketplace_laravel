<x-admin::app>

    @switch(Route::currentRouteName())
        @case('admin.um.user.create')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('User Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.create />
        @break

        @case('admin.um.user.edit')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('User Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.edit :data="$user" />
        @break

        @case('admin.um.user.view')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('User View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.view :user="$user" />
        @break

        @case('admin.um.user.profileInfo')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('Profile Info') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.profile.persona-info :user="$user" />
        @break

        @case('admin.um.user.shopInfo')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('Shop Info') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.profile.shop-info :user="$user" />
        @break

        @case('admin.um.user.kycInfo')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('KYC Info') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.profile.kyc-info :user="$user" />
        @break

        @case('admin.um.user.statistic')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('Statistic Info') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.profile.statistic :user="$user" />
        @break

        @case('admin.um.user.referral')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('Statistic Info') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.profile.referral :user="$user" />
        @break

        @case('admin.um.user.trash')
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="title">{{ __('User Trash') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.trash />
        @break

        @case('admin.um.user.all-seller')
            <x-slot name="pageSlug">{{ __('sellers') }}</x-slot>
            <x-slot name="title">{{ __('All Seller') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Seller Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.seller.all-seller />
        @break

        @case('admin.um.user.seller-trash')
            <x-slot name="pageSlug">{{ __('sellers') }}</x-slot>
            <x-slot name="title">{{ __('Seller Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.seller.seller-trash />
        @break

        @case('admin.um.user.banned-user')
            <x-slot name="pageSlug">{{ __('admin-users-banned') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management / Banned User List') }}</x-slot>
            <x-slot name="title">{{ __('Banned User List') }}</x-slot>
            <livewire:backend.admin.user-management.user.banned-user />
        @break

        @case('admin.um.user.all-buyer')
            <x-slot name="pageSlug">{{ __('buyers') }}</x-slot>
            <x-slot name="title">{{ __('All Buyer') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Buyer Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.buyer.all-buyer />
        @break

        @case('admin.um.user.buyer-trash')
            <x-slot name="pageSlug">{{ __('buyers') }}</x-slot>
            <x-slot name="title">{{ __('Buyer Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Buyer Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.buyer.buyer-trash />
        @break

        @case('admin.um.user.pending-verification')
            <x-slot name="pageSlug">{{ __('seller-verification-pending') }}</x-slot>
            <x-slot name="title">{{ __('Seller Pending Verificaiton') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Seller Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.seller.pending-verification />
        @break

        @case('admin.um.user.seller-verification.view')
            <x-slot name="pageSlug">{{ __('seller-verification-pending') }}</x-slot>
            <x-slot name="title">{{ __('Seller Verificaiton Details') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Seller Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.seller.verification-details :encryptedId="$encryptedId" />
        @break

        @case('admin.um.user.seller-verification.verified')
            <x-slot name="pageSlug">{{ __('seller-verification-verified') }}</x-slot>
            <x-slot name="title">{{ __('Seller Verified') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Seller Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.seller.verified-verification />
        @case('admin.um.user.seller.view')
            <x-slot name="pageSlug">{{ __('sellers') }}</x-slot>
            <x-slot name="title">{{ __('Seller Details') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Seller Management') }}</x-slot>
            <livewire:backend.admin.user-management.user.seller.seller-details :encryptedId="$encryptedId" />
        @break

        @case('admin.um.user.feedback')
            <x-slot name="pageSlug">{{ __('feedback') }}</x-slot>
            <x-slot name="title">{{ __('Feedback') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Feedback') }}</x-slot>

            <livewire:backend.admin.user-management.feedback.index :userId="$userId" />
        @break

        @default
            <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management / List') }}</x-slot>
            <x-slot name="title">{{ __('User List') }}</x-slot>
            <livewire:backend.admin.user-management.user.index />
    @endswitch

</x-admin::app>
