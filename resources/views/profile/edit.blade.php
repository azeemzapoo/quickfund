@extends('layouts.app')

@section('content')
@php
    $nameParts = preg_split('/\s+/', trim($user->name));
    $initials = collect($nameParts)->filter()->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('') ?: 'QF';
@endphp

<style>
    .profile-shell {
        color: #111827;
    }

    .profile-hero {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 24px;
        align-items: stretch;
        margin-bottom: 24px;
    }

    .profile-card,
    .profile-panel {
        border: 1px solid #dfe4ea;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 14px 32px rgba(17, 24, 39, 0.04);
    }

    .profile-card {
        padding: 28px;
        min-height: 260px;
        background:
            radial-gradient(circle at 88% 18%, rgba(32, 164, 119, 0.13), transparent 30%),
            linear-gradient(135deg, #ffffff 0%, #f7fbf8 100%);
    }

    .profile-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        background: #edf8f2;
        color: #1fa176;
        font-size: 14px;
        font-weight: 700;
        padding: 8px 14px;
        margin-bottom: 22px;
    }

    .profile-avatar {
        display: grid;
        place-items: center;
        width: 76px;
        height: 76px;
        border-radius: 24px;
        background: #20a477;
        color: #ffffff;
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 20px;
        box-shadow: 0 16px 30px rgba(32, 164, 119, 0.25);
    }

    .profile-title {
        margin: 0;
        font-size: clamp(34px, 5vw, 58px);
        line-height: 0.95;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .profile-title span {
        color: #20a477;
    }

    .profile-copy {
        margin-top: 16px;
        color: #6b7280;
        font-size: 16px;
        line-height: 1.7;
        max-width: 560px;
    }

    .profile-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 26px;
    }

    .profile-stat {
        border-radius: 14px;
        background: #f7f5ef;
        padding: 16px;
    }

    .profile-stat strong {
        display: block;
        font-size: 24px;
        line-height: 1;
    }

    .profile-stat span {
        display: block;
        margin-top: 8px;
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
    }

    .profile-panel {
        padding: 28px;
    }

    .panel-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .panel-heading h2 {
        margin: 0;
        font-size: 22px;
        letter-spacing: -0.03em;
        font-weight: 800;
    }

    .panel-heading p {
        margin: 8px 0 0;
        color: #6b7280;
        line-height: 1.6;
    }

    .profile-badge {
        border-radius: 999px;
        background: #edf8f2;
        color: #1fa176;
        font-size: 12px;
        font-weight: 800;
        padding: 8px 12px;
        white-space: nowrap;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
    }

    .form-stack {
        display: grid;
        gap: 18px;
    }

    .form-field label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 14px;
        font-weight: 800;
    }

    .profile-input {
        width: 100%;
        border: 1px solid #dfe4ea;
        border-radius: 12px;
        background: #ffffff;
        padding: 13px 15px;
        color: #111827;
        outline: none;
        transition: border-color 160ms ease, box-shadow 160ms ease;
    }

    .profile-input:focus {
        border-color: #20a477;
        box-shadow: 0 0 0 4px rgba(32, 164, 119, 0.12);
    }

    .profile-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 6px;
    }

    .profile-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        border: 0;
        border-radius: 12px;
        padding: 0 22px;
        font-weight: 800;
        cursor: pointer;
        transition: transform 160ms ease, background 160ms ease;
    }

    .profile-button:hover {
        transform: translateY(-1px);
    }

    .profile-button.primary {
        background: #20a477;
        color: #ffffff;
    }

    .profile-button.primary:hover {
        background: #168b65;
    }

    .profile-button.danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .profile-button.danger:hover {
        background: #fecaca;
    }

    .profile-button.muted {
        background: #f3f4f6;
        color: #374151;
    }

    .saved-note {
        color: #1fa176;
        font-size: 14px;
        font-weight: 800;
    }

    .verify-note {
        margin-top: 10px;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.6;
    }

    .verify-note button {
        color: #20a477;
        font-weight: 800;
        text-decoration: underline;
    }

    .danger-panel {
        margin-top: 24px;
        border-color: #f2d6d6;
        background:
            radial-gradient(circle at 92% 10%, rgba(239, 68, 68, 0.09), transparent 28%),
            #ffffff;
    }

    .error-text {
        margin-top: 8px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 700;
    }

    .profile-modal {
        padding: 28px;
    }

    .profile-modal h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .profile-modal p {
        margin: 10px 0 0;
        color: #6b7280;
        line-height: 1.6;
    }

    @media (max-width: 980px) {
        .profile-hero,
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .profile-card,
        .profile-panel {
            padding: 22px;
        }

        .profile-stats {
            grid-template-columns: 1fr;
        }

        .panel-heading,
        .profile-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .profile-button {
            width: 100%;
        }
    }
</style>

<div class="profile-shell">
    <div class="profile-hero">
        <section class="profile-card">
            <div class="profile-eyebrow">Profile Settings</div>
            <div class="profile-avatar">{{ $initials }}</div>
            <h1 class="profile-title">Manage Your <span>QuickFund</span> Account.</h1>
            <p class="profile-copy">
                Keep your identity, email, and password up to date so your ideas, pledges, contributions, and investments stay connected to the right account.
            </p>
        </section>

        <section class="profile-panel">
            <div class="panel-heading">
                <div>
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                </div>
                <span class="profile-badge">{{ $user->email_verified_at ? 'Verified' : 'Needs verification' }}</span>
            </div>

            <div class="profile-stats">
                <div class="profile-stat">
                    <strong>{{ $user->ideas()->count() }}</strong>
                    <span>Ideas posted</span>
                </div>
                <div class="profile-stat">
                    <strong>{{ $user->pledges()->count() }}</strong>
                    <span>Supports made</span>
                </div>
                <div class="profile-stat">
                    <strong>{{ $user->contributions()->count() }}</strong>
                    <span>Contributions</span>
                </div>
            </div>
        </section>
    </div>

    <div class="profile-grid">
        <section class="profile-panel">
            <div class="panel-heading">
                <div>
                    <h2>Profile Information</h2>
                    <p>Update your public name and account email address.</p>
                </div>
            </div>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="form-stack">
                @csrf
                @method('patch')

                <div class="form-field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="profile-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="profile-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <p class="verify-note">
                            Your email address is unverified.
                            <button form="send-verification">Resend verification email</button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="saved-note">A new verification link has been sent to your email address.</p>
                        @endif
                    @endif
                </div>

                <div class="profile-actions">
                    <button type="submit" class="profile-button primary">Save Profile</button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2200)"
                            class="saved-note"
                        >Saved successfully.</p>
                    @endif
                </div>
            </form>
        </section>

        <section class="profile-panel">
            <div class="panel-heading">
                <div>
                    <h2>Update Password</h2>
                    <p>Use a strong password to protect your funding activity.</p>
                </div>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="form-stack">
                @csrf
                @method('put')

                <div class="form-field">
                    <label for="update_password_current_password">Current Password</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="profile-input" autocomplete="current-password">
                    @foreach ($errors->updatePassword->get('current_password') as $message)
                        <p class="error-text">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="form-field">
                    <label for="update_password_password">New Password</label>
                    <input id="update_password_password" name="password" type="password" class="profile-input" autocomplete="new-password">
                    @foreach ($errors->updatePassword->get('password') as $message)
                        <p class="error-text">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="form-field">
                    <label for="update_password_password_confirmation">Confirm Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="profile-input" autocomplete="new-password">
                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                        <p class="error-text">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="profile-actions">
                    <button type="submit" class="profile-button primary">Update Password</button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2200)"
                            class="saved-note"
                        >Password updated.</p>
                    @endif
                </div>
            </form>
        </section>
    </div>

    <section class="profile-panel danger-panel">
        <div class="panel-heading">
            <div>
                <h2>Delete Account</h2>
                <p>
                    This permanently removes your account. Laravel will ask for your password before deleting it, so there is one final safety check.
                </p>
            </div>
            <button
                type="button"
                class="profile-button danger"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >
                Delete Account
            </button>
        </div>
    </section>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="profile-modal">
            @csrf
            @method('delete')

            <h2>Are you sure you want to delete your account?</h2>
            <p>
                Once your account is deleted, all of its resources and data will be permanently deleted. Enter your password to confirm this action.
            </p>

            <div class="form-field" style="margin-top: 22px;">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="profile-input" placeholder="Password">
                @foreach ($errors->userDeletion->get('password') as $message)
                    <p class="error-text">{{ $message }}</p>
                @endforeach
            </div>

            <div class="profile-actions" style="justify-content: flex-end; margin-top: 24px;">
                <button type="button" class="profile-button muted" x-on:click="$dispatch('close')">Cancel</button>
                <button type="submit" class="profile-button danger">Delete Account</button>
            </div>
        </form>
    </x-modal>
</div>
@endsection
