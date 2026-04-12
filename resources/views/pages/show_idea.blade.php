@extends('layouts.app')

@section('content')
@php
    $creator = trim(optional($idea->user)->name ?? 'Unknown Creator');
    $parts = preg_split('/\s+/', $creator, -1, PREG_SPLIT_NO_EMPTY);
    $initials = collect($parts)->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('') ?: 'NA';
    $goal = max((int) $idea->funding_goal, 1);
    $current = max((int) $idea->current_amount, 0);
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
            </section>

            <section class="side-card">
                <div class="support-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2fb289" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10a4 4 0 0 1 7-2.65A4 4 0 0 1 19 11c0 5.65-7 10-7 10Z"/>
                    </svg>
                    <span>Support this idea</span>
                </div>
                <div class="support-form">
                    <input type="text" class="support-input" placeholder="Amount ($)">
                    <button type="button" class="support-btn">Support</button>
                </div>
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
                <a href="#" class="invest-btn">Start Investing</a>
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
                <select class="contribute-select">
                    <option>Select your skill</option>
                    <option>Developer</option>
                    <option>Designer</option>
                    <option>Marketing</option>
                    <option>Research</option>
                </select>
                <button type="button" class="contribute-btn">Apply to Contribute</button>
            </section>
        </aside>
    </div>
</div>
@endsection
