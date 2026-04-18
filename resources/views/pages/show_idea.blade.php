@extends('layouts.app')

@section('content')
@php
    $creator = trim(optional($idea->user)->name ?? 'Unknown Creator');
    $parts = preg_split('/\s+/', $creator, -1, PREG_SPLIT_NO_EMPTY);
    $initials = collect($parts)->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('') ?: 'NA';
    $goal = max((int) $idea->funding_goal, 1);
    $current = max((int) $idea->current_amount, 0);
    $remaining = max(0, $goal - $current);
    $progress = min((int) round(($current / $goal) * 100), 100);
    $daysLeft = max(1, 30 - (int) optional($idea->created_at)->diffInDays(now()));
    $text = strtolower(trim($idea->title . ' ' . $idea->description));
    $category = match (true) {
        str_contains($text, 'edu') || str_contains($text, 'learn') || str_contains($text, 'student') || str_contains($text, 'tutor') => 'EdTech',
        str_contains($text, 'green') || str_contains($text, 'waste') || str_contains($text, 'sustain') || str_contains($text, 'food') => 'Sustainability',
        str_contains($text, 'career') || str_contains($text, 'job') || str_contains($text, 'skill') || str_contains($text, 'portfolio') => 'Career',
        str_contains($text, 'home') || str_contains($text, 'housing') || str_contains($text, 'rent') || str_contains($text, 'room') => 'Housing',
        str_contains($text, 'transport') || str_contains($text, 'travel') || str_contains($text, 'bus') || str_contains($text, 'ride') => 'Transportation',
        default => 'General',
    };
    $contributors = $idea->contributions->take(4);
    $roleColors = [
        'developer' => ['bg' => '#eef2ff', 'color' => '#4f6cf6'],
        'designer' => ['bg' => '#fde8f2', 'color' => '#e95da8'],
        'marketing' => ['bg' => '#fff2df', 'color' => '#f59f0b'],
        'research' => ['bg' => '#eaf7f1', 'color' => '#2fb289'],
    ];
@endphp

<style>
    .idea-detail-shell {
        background: #fcfaf5;
        margin: -3rem -2rem;
        padding: 1rem 2rem 3rem;
        min-height: calc(100vh - 90px);
    }

    .idea-detail-wrap {
        max-width: 1290px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.75fr) minmax(330px, 0.9fr);
        gap: 1.9rem;
        align-items: start;
    }

    .detail-main {
        background: #fff;
        border: 1px solid #dce4ee;
        border-radius: 22px;
        padding: 1.6rem 1.6rem 2rem;
        box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
    }

    .detail-side {
        display: grid;
        gap: 1.25rem;
    }

    .detail-topbar {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        color: #6b7a96;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .detail-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        background: #f4efe6;
        color: #22314b;
        font-size: 0.9rem;
        font-weight: 700;
        line-height: 1;
    }

    .detail-days {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .detail-title {
        margin: 1rem 0 0;
        color: #102748;
        font-size: 3rem;
        line-height: 1.02;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .detail-author {
        display: flex;
        align-items: center;
        gap: 0.95rem;
        margin-top: 1rem;
    }

    .detail-author__badge {
        width: 3rem;
        height: 3rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #e8f6ef;
        color: #2fb289;
        font-size: 0.95rem;
        font-weight: 800;
    }

    .detail-author__meta strong {
        display: block;
        color: #102748;
        font-size: 0.98rem;
        font-weight: 700;
    }

    .detail-author__meta span {
        display: block;
        color: #6b7a96;
        font-size: 0.88rem;
        margin-top: 0.15rem;
    }

    .detail-copy {
        margin: 1.35rem 0 0;
        color: #60708a;
        font-size: 0.98rem;
        line-height: 1.9;
        max-width: 96%;
    }

    .detail-section-title {
        margin: 2rem 0 1rem;
        color: #102748;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .owner-actions {
        display: flex;
        gap: 0.8rem;
        margin-top: 1.35rem;
        flex-wrap: wrap;
    }

    .owner-action {
        min-height: 42px;
        padding: 0 1rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 0.92rem;
        font-weight: 700;
    }

    .owner-action.edit {
        background: #2fb289;
        color: #fff;
    }

    .owner-action.delete {
        border: 0;
        background: #e25353;
        color: #fff;
    }

    .owner-action.view {
        border: 1px solid #d9e1ec;
        background: #fff;
        color: #22314b;
    }

    .contributors-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.8rem;
    }

    .contributor-card {
        border: 1px solid #dce4ee;
        border-radius: 16px;
        background: #fff;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .contributor-badge {
        width: 2.25rem;
        height: 2.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #f5f4ef;
        color: #22314b;
        font-size: 0.8rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .contributor-meta strong {
        display: block;
        color: #102748;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .contributor-role {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.28rem;
        padding: 0.23rem 0.55rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        line-height: 1;
    }

    .side-card {
        background: #fff;
        border: 1px solid #dce4ee;
        border-radius: 18px;
        padding: 1.25rem;
        box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
    }

    .side-card h3 {
        margin: 0;
        color: #102748;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .fund-amount-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 1rem;
    }

    .fund-amount {
        color: #2fb289;
        font-size: 2.25rem;
        line-height: 1;
        font-weight: 800;
    }

    .fund-goal {
        color: #6b7a96;
        font-size: 0.95rem;
    }

    .fund-progress {
        height: 12px;
        margin-top: 0.85rem;
        border-radius: 999px;
        background: #efe9df;
        overflow: hidden;
    }

    .fund-progress__bar {
        height: 100%;
        border-radius: 999px;
        background: #2fb289;
    }

    .fund-stats {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 0.85rem;
        color: #6b7a96;
        font-size: 0.94rem;
    }

    .fund-remaining {
        margin-top: 0.85rem;
        color: #6b7a96;
        font-size: 0.93rem;
        font-weight: 600;
    }

    .support-header,
    .join-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: #102748;
        font-size: 0.98rem;
        font-weight: 800;
    }

    .support-form {
        display: grid;
        grid-template-columns: 1fr 96px;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .support-input,
    .contribute-select {
        width: 100%;
        height: 42px;
        border: 1px solid #d9e1ec;
        border-radius: 12px;
        padding: 0 0.85rem;
        color: #42506a;
        background: #fff;
        font-size: 0.95rem;
        outline: none;
    }

    .support-input:focus,
    .contribute-select:focus {
        border-color: #2fb289;
        box-shadow: 0 0 0 4px rgba(47, 178, 137, 0.12);
    }

    .support-btn,
    .invest-btn,
    .contribute-btn {
        height: 42px;
        border: 0;
        border-radius: 12px;
        color: #fff;
        font-size: 0.95rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .support-btn { background: #2fb289; }
    .invest-box {
        border: 2px solid #cfc9fb;
        background: #faf8ff;
    }

    .invest-box p {
        margin: 0.65rem 0 0;
        color: #6b7a96;
        font-size: 0.95rem;
        line-height: 1.65;
    }

    .invest-btn {
        width: 100%;
        margin-top: 0.95rem;
        background: #6a5ae0;
    }

    .invest-input {
        width: 100%;
        height: 42px;
        margin-top: 0.95rem;
        border: 1px solid #d8d2fb;
        border-radius: 12px;
        background: #fff;
        color: #42506a;
        font-size: 0.95rem;
        padding: 0 0.85rem;
        outline: none;
    }

    .invest-input:focus {
        border-color: #6a5ae0;
        box-shadow: 0 0 0 4px rgba(106, 90, 224, 0.12);
    }

    .join-copy {
        margin: 0.65rem 0 0;
        color: #6b7a96;
        font-size: 0.95rem;
        line-height: 1.65;
    }

    .contribute-select {
        margin-top: 0.95rem;
    }

    .contribute-btn {
        width: 100%;
        margin-top: 0.8rem;
        background: #2d9cdb;
    }

    .flash-message,
    .error-list {
        border-radius: 16px;
        padding: 0.95rem 1rem;
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .flash-message {
        margin-bottom: 1rem;
        border: 1px solid #cfe9de;
        background: #edf8f2;
        color: #23795e;
        font-weight: 700;
    }

    .flash-message.error {
        border-color: #f2d0d0;
        background: #fff2f2;
        color: #be3f3f;
    }

    .error-list {
        margin-top: 0.85rem;
        border: 1px solid #f2d0d0;
        background: #fff2f2;
        color: #be3f3f;
    }

    @media (max-width: 1024px) {
        .idea-detail-wrap {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .idea-detail-shell {
            margin: -3rem -1rem;
            padding: 1rem 1rem 2rem;
        }

        .detail-title {
            font-size: 2.2rem;
        }

        .contributors-grid,
        .support-form {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="idea-detail-shell">
    <div class="idea-detail-wrap">
        <section class="detail-main">
            <div class="detail-topbar">
                <span class="detail-chip">{{ $category }}</span>
                <span class="detail-days">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path stroke-linecap="round" d="M12 7v5l3 2"></path>
                    </svg>
                    {{ $daysLeft }} days left
                </span>
            </div>

            <h1 class="detail-title">{{ $idea->title }}</h1>

            <div class="detail-author">
                <span class="detail-author__badge">{{ $initials }}</span>
                <div class="detail-author__meta">
                    <strong>{{ $creator }}</strong>
                    <span>Creator</span>
                </div>
            </div>

            @auth
                @if (auth()->id() === $idea->user_id)
                    <div class="owner-actions">
                        <a href="{{ route('ideas.edit', $idea->id) }}" class="owner-action edit">Edit Idea</a>
                        <form method="POST" action="{{ route('ideas.destroy', $idea->id) }}" onsubmit="return confirm('Are you sure you want to delete this idea?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="owner-action delete">Delete Idea</button>
                        </form>
                        <a href="{{ route('ideas.index') }}" class="owner-action view">Back to Ideas</a>
                    </div>
                @endif
            @endauth

            <p class="detail-copy">{{ $idea->description }}</p>

            <h2 class="detail-section-title">Team &amp; Contributors</h2>

            <div class="contributors-grid">
                @forelse ($contributors as $contribution)
                    @php
                        $name = trim(optional($contribution->user)->name ?? 'Team Member');
                        $memberParts = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
                        $memberInitials = collect($memberParts)->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('') ?: 'TM';
                        $roleKey = strtolower($contribution->role);
                        $roleStyle = $roleColors[$roleKey] ?? ['bg' => '#eef6ff', 'color' => '#2d9cdb'];
                    @endphp
                    <div class="contributor-card">
                        <span class="contributor-badge">{{ $memberInitials }}</span>
                        <div class="contributor-meta">
                            <strong>{{ $name }}</strong>
                            <span class="contributor-role" style="background: {{ $roleStyle['bg'] }}; color: {{ $roleStyle['color'] }};">
                                {{ ucfirst($contribution->role) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="contributor-card">
                        <span class="contributor-badge">{{ $initials }}</span>
                        <div class="contributor-meta">
                            <strong>{{ $creator }}</strong>
                            <span class="contributor-role" style="background: #eef6ff; color: #2d9cdb;">Founder</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <aside class="detail-side">
            <section class="side-card">
                <h3>Funding Progress</h3>
                <div class="fund-amount-row">
                    <span class="fund-amount">${{ number_format($current) }}</span>
                    <span class="fund-goal">of ${{ number_format($goal) }}</span>
                </div>
                <div class="fund-progress">
                    <div class="fund-progress__bar" style="width: {{ $progress }}%;"></div>
                </div>
                <div class="fund-stats">
                    <span>{{ $idea->pledges_count }} supporters</span>
                    <span>{{ $idea->investments_count }} investors</span>
                </div>
                <div class="fund-remaining">
                    ${{ number_format($remaining) }} remaining to reach the goal
                </div>
            </section>

            <section class="side-card">
                <div class="support-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2fb289" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10a4 4 0 0 1 7-2.65A4 4 0 0 1 19 11c0 5.65-7 10-7 10Z"/>
                    </svg>
                    <span>Support this idea</span>
                </div>
                <p class="join-copy" style="margin-top: 0.85rem;">Remaining amount available: ${{ number_format($remaining) }}</p>

                @if (session('success'))
                    <div class="flash-message">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="flash-message error">{{ session('error') }}</div>
                @endif

                @auth
                    <form method="POST" action="{{ route('pledges.store') }}">
                        @csrf
                        <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                        <div class="support-form">
                            <input
                                type="number"
                                name="amount"
                                min="1"
                                step="1"
                                class="support-input"
                                placeholder="Amount ($)"
                                value="{{ old('amount') }}"
                            >
                            <button type="submit" class="support-btn">Support</button>
                        </div>
                    </form>

                    @if ($errors->has('amount') || $errors->has('idea_id'))
                        <div class="error-list">
                            @error('amount')
                                <div>{{ $message }}</div>
                            @enderror
                            @error('idea_id')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="support-btn" style="width:100%; margin-top: 1rem; text-decoration:none;">Log in to Support</a>
                @endauth
            </section>

            <section class="side-card invest-box">
                <div class="support-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6a5ae0" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15 10 10l4 4 5-7"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7h-4m4 0v4"/>
                    </svg>
                    <span>Invest in {{ $idea->title }}</span>
                </div>
                <p>Become an early investor and grow with this idea.</p>
                <p class="join-copy" style="margin-top: 0.6rem;">Remaining amount available: ${{ number_format($remaining) }}</p>

                @if (session('investment_success'))
                    <div class="flash-message" style="margin-top: 0.9rem;">{{ session('investment_success') }}</div>
                @endif

                @if (session('investment_error'))
                    <div class="flash-message error" style="margin-top: 0.9rem;">{{ session('investment_error') }}</div>
                @endif

                @auth
                    <form method="POST" action="{{ route('investments.store') }}">
                        @csrf
                        <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                        <input
                            type="number"
                            name="amount"
                            min="1"
                            step="1"
                            class="invest-input"
                            placeholder="Investment amount ($)"
                            value="{{ old('amount') }}"
                        >
                        <button type="submit" class="invest-btn">Start Investing</button>
                    </form>

                    @if ($errors->investment->has('amount') || $errors->investment->has('idea_id'))
                        <div class="error-list">
                            @if ($errors->investment->has('amount'))
                                <div>{{ $errors->investment->first('amount') }}</div>
                            @endif
                            @if ($errors->investment->has('idea_id'))
                                <div>{{ $errors->investment->first('idea_id') }}</div>
                            @endif
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="invest-btn" style="text-decoration:none;">Log in to Invest</a>
                @endauth
            </section>

            <section class="side-card">
                <div class="join-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2d9cdb" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                        <circle cx="10" cy="7" r="4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21v-2a4 4 0 0 0-3-3.87"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>Join as Contributor</span>
                </div>
                <p class="join-copy">Collaborate with the team by bringing your skills to the project.</p>

                @if (session('contribution_success'))
                    <div class="flash-message" style="margin-top: 0.9rem;">{{ session('contribution_success') }}</div>
                @endif

                @if (session('contribution_error'))
                    <div class="flash-message error" style="margin-top: 0.9rem;">{{ session('contribution_error') }}</div>
                @endif

                @auth
                    <form method="POST" action="{{ route('contributions.store') }}">
                        @csrf
                        <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                        <select name="role" class="contribute-select">
                            <option value="">Select your skill</option>
                            <option value="Developer" @selected(old('role') === 'Developer')>Developer</option>
                            <option value="Designer" @selected(old('role') === 'Designer')>Designer</option>
                            <option value="Marketing" @selected(old('role') === 'Marketing')>Marketing</option>
                            <option value="Research" @selected(old('role') === 'Research')>Research</option>
                        </select>
                        <button type="submit" class="contribute-btn">Apply to Contribute</button>
                    </form>

                    @if ($errors->contribution->has('role') || $errors->contribution->has('idea_id'))
                        <div class="error-list">
                            @if ($errors->contribution->has('role'))
                                <div>{{ $errors->contribution->first('role') }}</div>
                            @endif
                            @if ($errors->contribution->has('idea_id'))
                                <div>{{ $errors->contribution->first('idea_id') }}</div>
                            @endif
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="contribute-btn" style="text-decoration:none;">Log in to Contribute</a>
                @endauth
            </section>
        </aside>
    </div>
</div>
@endsection
