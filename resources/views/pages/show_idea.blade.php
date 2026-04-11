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
@endphp

<style>
    .idea-show-shell {
        background: #fcfaf5;
        margin: -3rem -2rem;
        padding: 1.5rem 2rem 3rem;
        min-height: calc(100vh - 90px);
    }

    .idea-show-wrap {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
        gap: 1.8rem;
    }

    .show-main,
    .show-side {
        background: #fff;
        border: 1px solid #dce4ee;
        border-radius: 24px;
        box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
    }

    .show-main {
        padding: 2rem;
    }

    .show-side {
        padding: 1.7rem;
    }

    .show-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .show-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.58rem 1rem;
        border-radius: 999px;
        background: #ecf8f2;
        color: #2fb289;
        font-size: 0.92rem;
        font-weight: 700;
    }

    .show-days {
        color: #6b7a96;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .show-title {
        margin: 1.2rem 0 0;
        color: #102748;
        font-size: 2.9rem;
        line-height: 1.04;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .show-description {
        margin: 1rem 0 0;
        color: #60708a;
        font-size: 1.02rem;
        line-height: 1.85;
    }

    .show-author {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        margin-top: 1.5rem;
    }

    .show-author__badge {
        width: 3rem;
        height: 3rem;
        border-radius: 999px;
        background: #e8f6ef;
        color: #2fb289;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .show-author__meta strong {
        display: block;
        color: #102748;
        font-size: 1rem;
    }

    .show-author__meta span {
        color: #6b7a96;
        font-size: 0.92rem;
    }

    .show-metrics {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 1.7rem;
    }

    .show-metric {
        border: 1px solid #e4ebf3;
        border-radius: 18px;
        background: #fcfaf5;
        padding: 1rem 1.1rem;
    }

    .show-metric label {
        display: block;
        color: #6b7a96;
        font-size: 0.9rem;
        margin-bottom: 0.35rem;
    }

    .show-metric strong {
        color: #102748;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .show-progress-title {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 1.8rem;
    }

    .show-progress-title strong {
        color: #102748;
        font-size: 2rem;
        font-weight: 800;
    }

    .show-progress-title span {
        color: #6b7a96;
        font-size: 1rem;
    }

    .show-progress {
        height: 12px;
        margin-top: 0.85rem;
        background: #efe9df;
        border-radius: 999px;
        overflow: hidden;
    }

    .show-progress__bar {
        height: 100%;
        background: #2fb289;
        border-radius: 999px;
    }

    .show-actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.8rem;
        margin-top: 1.6rem;
    }

    .show-btn,
    .show-link {
        min-height: 48px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .show-btn.green { background: #2fb289; color: #fff; }
    .show-btn.purple { background: #6a5ae0; color: #fff; }
    .show-btn.blue { background: #2d9cdb; color: #fff; }
    .show-link {
        margin-top: 1.2rem;
        border: 1px solid #d9e1ec;
        background: #fff;
        color: #22314b;
    }

    .side-title {
        margin: 0;
        color: #102748;
        font-size: 1.2rem;
        font-weight: 800;
    }

    .side-copy {
        margin: 0.75rem 0 0;
        color: #6b7a96;
        line-height: 1.7;
        font-size: 0.95rem;
    }

    .side-stack {
        display: grid;
        gap: 0.95rem;
        margin-top: 1.4rem;
    }

    .side-card {
        border-radius: 18px;
        padding: 1rem 1.05rem;
        color: #fff;
    }

    .side-card.green { background: #2fb289; }
    .side-card.purple { background: #6a5ae0; }
    .side-card.blue { background: #2d9cdb; }

    .side-card strong {
        display: block;
        font-size: 0.98rem;
        margin-bottom: 0.35rem;
    }

    .side-card span {
        display: block;
        font-size: 0.9rem;
        line-height: 1.6;
        opacity: 0.96;
    }

    @media (max-width: 900px) {
        .idea-show-shell {
            margin: -3rem -1rem;
            padding: 1rem 1rem 2rem;
        }

        .idea-show-wrap {
            grid-template-columns: 1fr;
        }

        .show-title {
            font-size: 2.2rem;
        }

        .show-metrics,
        .show-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="idea-show-shell">
    <div class="idea-show-wrap">
        <section class="show-main">
            <div class="show-top">
                <span class="show-chip">Idea Details</span>
                <span class="show-days">{{ $daysLeft }} days left</span>
            </div>

            <h1 class="show-title">{{ $idea->title }}</h1>
            <p class="show-description">{{ $idea->description }}</p>

            <div class="show-author">
                <span class="show-author__badge">{{ $initials }}</span>
                <div class="show-author__meta">
                    <strong>{{ $creator }}</strong>
                    <span>Created {{ optional($idea->created_at)->diffForHumans() }}</span>
                </div>
            </div>

            <div class="show-metrics">
                <div class="show-metric">
                    <label>Supporters</label>
                    <strong>{{ $idea->pledges_count }}</strong>
                </div>
                <div class="show-metric">
                    <label>Investors</label>
                    <strong>{{ $idea->investments_count }}</strong>
                </div>
                <div class="show-metric">
                    <label>Contributors</label>
                    <strong>{{ $idea->contributions_count }}</strong>
                </div>
            </div>

            <div class="show-progress-title">
                <strong>${{ number_format($current) }}</strong>
                <span>of ${{ number_format($goal) }} goal</span>
            </div>

            <div class="show-progress">
                <div class="show-progress__bar" style="width: {{ $progress }}%;"></div>
            </div>

            <div class="show-actions">
                <a href="#" class="show-btn green">Support</a>
                <a href="#" class="show-btn purple">Invest</a>
                <a href="#" class="show-btn blue">Contribute</a>
            </div>

            <a href="{{ route('ideas.index') }}" class="show-link">Back to Explore Ideas</a>
        </section>

        <aside class="show-side">
            <h2 class="side-title">Ways people can help</h2>
            <p class="side-copy">
                This page is now the next step after the explore list. It keeps the same QuickFund colors and gives users a clear snapshot of the idea.
            </p>

            <div class="side-stack">
                <div class="side-card green">
                    <strong>Support</strong>
                    <span>Small pledges help the idea build traction and show early interest.</span>
                </div>

                <div class="side-card purple">
                    <strong>Invest</strong>
                    <span>Investors can help push the project toward its funding goal faster.</span>
                </div>

                <div class="side-card blue">
                    <strong>Contribute</strong>
                    <span>People can also join the project with skills, time, and collaboration.</span>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
