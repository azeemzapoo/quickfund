@extends('layouts.app')

@section('content')
@php
    $displayName = explode(' ', trim($user->name))[0] ?? $user->name;
@endphp

<style>
    .dashboard-shell {
        background: #fcfaf5;
        margin: -3rem -2rem;
        padding: 1.25rem 2rem 3rem;
        min-height: calc(100vh - 90px);
    }

    .dashboard-wrap {
        max-width: 1280px;
        margin: 0 auto;
    }

    .dashboard-title {
        margin: 0;
        color: #102748;
        font-size: 2.45rem;
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.04em;
    }

    .dashboard-subtitle {
        margin: 0.7rem 0 0;
        color: #6b7a96;
        font-size: 1rem;
        line-height: 1.6;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .stat-card,
    .dashboard-panel {
        background: #fff;
        border: 1px solid #dce4ee;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
    }

    .stat-card {
        padding: 1.2rem 1.3rem;
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .stat-label {
        color: #6b7a96;
        font-size: 0.95rem;
    }

    .stat-value {
        margin-top: 0.55rem;
        color: #102748;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .stat-icon.green { color: #2fb289; }
    .stat-icon.blue { color: #2d9cdb; }
    .stat-icon.purple { color: #6a5ae0; }

    .dashboard-main {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 1.8rem;
        margin-top: 1.8rem;
    }

    .dashboard-panel {
        padding: 1.25rem;
    }

    .panel-title {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin: 0;
        color: #102748;
        font-size: 1rem;
        font-weight: 800;
    }

    .panel-icon.green { color: #2fb289; }
    .panel-icon.blue { color: #2d9cdb; }

    .idea-list,
    .contribution-list {
        display: grid;
        gap: 1rem;
        margin-top: 1.25rem;
    }

    .idea-item,
    .contribution-item {
        border: 1px solid #dce4ee;
        border-radius: 16px;
        background: #fff;
        padding: 1rem;
    }

    .idea-head,
    .contribution-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .idea-name,
    .contribution-name {
        color: #102748;
        font-size: 0.98rem;
        font-weight: 800;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 30px;
        padding: 0 0.8rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        line-height: 1;
    }

    .status-badge.active {
        background: #2fb289;
        color: #fff;
    }

    .status-badge.pending {
        background: #f4efe6;
        color: #7f6c50;
    }

    .idea-money-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 0.7rem;
        color: #102748;
        font-size: 0.95rem;
    }

    .idea-progress {
        height: 8px;
        margin-top: 0.55rem;
        border-radius: 999px;
        background: #efe9df;
        overflow: hidden;
    }

    .idea-progress__bar {
        height: 100%;
        background: #2fb289;
        border-radius: 999px;
    }

    .idea-supporters {
        margin-top: 0.55rem;
        color: #6b7a96;
        font-size: 0.9rem;
    }

    .contribution-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .contribution-left {
        display: flex;
        align-items: center;
        gap: 0.95rem;
    }

    .contribution-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #f4f2ed;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #102748;
    }

    .contribution-role {
        margin-top: 0.2rem;
        color: #6b7a96;
        font-size: 0.92rem;
    }

    .panel-empty {
        margin-top: 1.2rem;
        color: #6b7a96;
        font-size: 0.95rem;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-main {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-shell {
            margin: -3rem -1rem;
            padding: 1rem 1rem 2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-title {
            font-size: 2rem;
        }

        .contribution-item {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="dashboard-shell">
    <div class="dashboard-wrap">
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Welcome back, {{ $displayName }}! Here's your overview.</p>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Ideas Posted</span>
                    <span class="stat-icon green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12c1.5-3 4.5-7 7-7 1.5 0 2.3 1 2.3 2.1 0 1.5-1.3 2.9-2.9 2.9h-1.1c-1.8 0-3.3 1.4-3.3 3.2 0 1.7 1.3 3 3 3 2.2 0 3.7-1.8 4.7-3.6L19 7"></path>
                        </svg>
                    </span>
                </div>
                <div class="stat-value">{{ $stats['ideas_posted'] }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Raised</span>
                    <span class="stat-icon green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </span>
                </div>
                <div class="stat-value">${{ number_format($stats['total_raised']) }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Supporters</span>
                    <span class="stat-icon blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </span>
                </div>
                <div class="stat-value">{{ $stats['supporters'] }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Investments Made</span>
                    <span class="stat-icon purple">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15 10 10l4 4 5-7"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7h-4m4 0v4"></path>
                        </svg>
                    </span>
                </div>
                <div class="stat-value">{{ $stats['investments_made'] }}</div>
            </div>
        </div>

        <div class="dashboard-main">
            <section class="dashboard-panel">
                <h2 class="panel-title">
                    <span class="panel-icon green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M7 16V5M12 16V9M17 16v-7"></path>
                        </svg>
                    </span>
                    <span>My Ideas</span>
                </h2>

                @if ($ideas->isEmpty())
                    <p class="panel-empty">You have not posted any ideas yet.</p>
                @else
                    <div class="idea-list">
                        @foreach ($ideas as $idea)
                            @php
                                $goal = max((int) $idea->funding_goal, 1);
                                $current = max((int) $idea->current_amount, 0);
                                $progress = min((int) round(($current / $goal) * 100), 100);
                                $supporters = $idea->pledges->count();
                                $status = $current > 0 ? 'Active' : 'Draft';
                            @endphp

                            <div class="idea-item">
                                <div class="idea-head">
                                    <div class="idea-name">{{ $idea->title }}</div>
                                    <span class="status-badge {{ $status === 'Active' ? 'active' : 'pending' }}">{{ $status }}</span>
                                </div>

                                <div class="idea-money-row">
                                    <span>${{ number_format($current) }}</span>
                                    <span>${{ number_format($goal) }} goal</span>
                                </div>

                                <div class="idea-progress">
                                    <div class="idea-progress__bar" style="width: {{ $progress }}%;"></div>
                                </div>

                                <div class="idea-supporters">{{ $supporters }} supporters</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="dashboard-panel">
                <h2 class="panel-title">
                    <span class="panel-icon blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </span>
                    <span>My Contributions</span>
                </h2>

                @if ($contributions->isEmpty())
                    <p class="panel-empty">You have not joined any idea teams yet.</p>
                @else
                    <div class="contribution-list">
                        @foreach ($contributions as $contribution)
                            @php
                                $ideaName = optional($contribution->idea)->title ?? 'Untitled Idea';
                                $role = $contribution->role;
                                $status = optional($contribution->idea)->current_amount > 0 ? 'Active' : 'Pending';
                            @endphp

                            <div class="contribution-item">
                                <div class="contribution-left">
                                    <span class="contribution-icon">
                                        @if ($role === 'Developer')
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m8 16-4-4 4-4M16 8l4 4-4 4"></path>
                                            </svg>
                                        @elseif ($role === 'Designer')
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a9 9 0 1 0 9 9c0-1.7-.6-3-2.4-3H16a2 2 0 0 1-2-2V4.4C14 3.6 13.3 3 12 3Z"></path>
                                                <circle cx="7.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                                <circle cx="10.5" cy="8.5" r=".5" fill="currentColor"></circle>
                                            </svg>
                                        @else
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h9M13 5l7 7-7 7"></path>
                                            </svg>
                                        @endif
                                    </span>

                                    <div>
                                        <div class="contribution-name">{{ $ideaName }}</div>
                                        <div class="contribution-role">Role: {{ $role }}</div>
                                    </div>
                                </div>

                                <span class="status-badge {{ $status === 'Active' ? 'active' : 'pending' }}">{{ $status }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
