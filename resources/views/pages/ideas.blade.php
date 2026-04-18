@extends('layouts.app')

@section('content')
@php
    $ideasWithMeta = $ideas->map(function ($idea) {
        $text = strtolower(trim($idea->title . ' ' . $idea->description));

        $category = match (true) {
            str_contains($text, 'edu') || str_contains($text, 'learn') || str_contains($text, 'student') || str_contains($text, 'tutor') => 'EdTech',
            str_contains($text, 'green') || str_contains($text, 'waste') || str_contains($text, 'sustain') || str_contains($text, 'food') => 'Sustainability',
            str_contains($text, 'career') || str_contains($text, 'job') || str_contains($text, 'skill') || str_contains($text, 'portfolio') => 'Career',
            str_contains($text, 'home') || str_contains($text, 'housing') || str_contains($text, 'rent') || str_contains($text, 'room') => 'Housing',
            str_contains($text, 'transport') || str_contains($text, 'travel') || str_contains($text, 'bus') || str_contains($text, 'ride') => 'Transportation',
            default => 'All',
        };

        $goal = max((int) $idea->funding_goal, 1);
        $current = max((int) $idea->current_amount, 0);
        $progress = min((int) round(($current / $goal) * 100), 100);
        $daysLeft = max(1, 30 - (int) optional($idea->created_at)->diffInDays(now()));
        $creator = trim(optional($idea->user)->name ?? 'Unknown Creator');
        $parts = preg_split('/\s+/', $creator, -1, PREG_SPLIT_NO_EMPTY);
        $initials = collect($parts)->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('');

        return [
            'id' => $idea->id,
            'title' => $idea->title,
            'description' => $idea->description,
            'category' => $category,
            'creator' => $creator,
            'initials' => $initials ?: 'NA',
            'current_amount' => $current,
            'funding_goal' => $goal,
            'progress' => $progress,
            'days_left' => $daysLeft,
            'supporters' => (int) $idea->pledges_count,
            'investors' => (int) $idea->investments_count,
        ];
    });

    $categories = collect(['All', 'EdTech', 'Sustainability', 'Career', 'Housing', 'Transportation'])
        ->merge($ideasWithMeta->pluck('category'))
        ->unique()
        ->values();
@endphp

<style>
    .ideas-shell {
        background: #fcfaf5;
        margin: -3rem -2rem;
        padding: 1.25rem 2rem 3rem;
        min-height: calc(100vh - 90px);
    }

    .ideas-wrap {
        max-width: 1290px;
        margin: 0 auto;
    }

    .ideas-title {
        margin: 0;
        color: #102748;
        font-size: 2.75rem;
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.04em;
    }

    .ideas-subtitle {
        margin: 0.75rem 0 0;
        color: #6b7a96;
        font-size: 1rem;
        line-height: 1.5;
    }

    .ideas-toolbar {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .ideas-search {
        position: relative;
        flex: 1 1 560px;
        max-width: 560px;
    }

    .ideas-search svg {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #8d97aa;
    }

    .ideas-search input {
        width: 100%;
        height: 50px;
        border: 1px solid #d9e1ec;
        border-radius: 16px;
        background: #fff;
        padding: 0 18px 0 52px;
        color: #4a5872;
        font-size: 1rem;
        outline: none;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
    }

    .ideas-search input:focus {
        border-color: #2fb289;
        box-shadow: 0 0 0 4px rgba(47, 178, 137, 0.12);
    }

    .ideas-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .ideas-filter {
        border: 1px solid #ece6da;
        border-radius: 999px;
        background: #f6f1e7;
        color: #22314b;
        padding: 0.65rem 1.15rem;
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1;
        cursor: pointer;
        transition: 0.18s ease;
    }

    .ideas-filter.is-active {
        background: #2fb289;
        border-color: #2fb289;
        color: #fff;
    }

    .ideas-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.7rem;
        margin-top: 2.6rem;
    }

    .idea-card {
        position: relative;
        border: 1px solid #dce4ee;
        border-radius: 20px;
        background: #fff;
        padding: 1.55rem 1.6rem 1.45rem;
        box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .idea-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 32px rgba(16, 24, 40, 0.08);
        border-color: #ced9e7;
    }

    .idea-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .idea-chip {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        background: #f4efe6;
        color: #22314b;
        padding: 0.58rem 1rem;
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1;
    }

    .idea-days {
        color: #6b7a96;
        font-size: 0.95rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .idea-name {
        margin: 1.45rem 0 0;
        color: #102748;
        font-size: 1.03rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .idea-description {
        margin: 1rem 0 0;
        color: #60708a;
        font-size: 1rem;
        line-height: 1.72;
        min-height: 122px;
    }

    .idea-author {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-top: 1.4rem;
    }

    .idea-author__badge {
        width: 2.6rem;
        height: 2.6rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #e8f6ef;
        color: #2fb289;
        font-size: 0.9rem;
        font-weight: 700;
    }

    .idea-author__name {
        color: #102748;
        font-size: 0.98rem;
        font-weight: 700;
    }

    .idea-money {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 1.35rem;
    }

    .idea-money__raised {
        color: #102748;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .idea-money__goal {
        color: #6b7a96;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .idea-progress {
        height: 10px;
        margin-top: 0.8rem;
        border-radius: 999px;
        background: #efe9df;
        overflow: hidden;
    }

    .idea-progress__bar {
        height: 100%;
        border-radius: 999px;
        background: #2fb289;
    }

    .idea-stats {
        display: flex;
        gap: 1.5rem;
        margin-top: 0.75rem;
        color: #6b7a96;
        font-size: 0.95rem;
    }

    .idea-actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.7rem;
        margin-top: 1.35rem;
    }

    .idea-btn {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        min-height: 46px;
        border-radius: 14px;
        color: #fff;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .idea-btn--support { background: #2fb289; }
    .idea-btn--invest { background: #6a5ae0; }
    .idea-btn--contribute { background: #2d9cdb; }

    .idea-empty {
        margin-top: 2.6rem;
        border: 1px solid #dce4ee;
        border-radius: 20px;
        background: #fff;
        padding: 3rem 2rem;
        text-align: center;
        color: #6b7a96;
    }

    .ideas-flash {
        margin-top: 1.5rem;
        border: 1px solid #cfe9de;
        border-radius: 16px;
        background: #edf8f2;
        color: #23795e;
        padding: 0.95rem 1rem;
        font-size: 0.92rem;
        line-height: 1.6;
        font-weight: 700;
    }

    @media (max-width: 1100px) {
        .ideas-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .ideas-shell {
            margin: -3rem -1rem;
            padding: 1rem 1rem 2rem;
        }

        .ideas-title {
            font-size: 2.2rem;
        }

        .ideas-grid {
            grid-template-columns: 1fr;
        }

        .idea-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ideas-shell">
    <div class="ideas-wrap" x-data="{ search: '', activeCategory: 'All' }">
        <h1 class="ideas-title">Explore Ideas</h1>
        <p class="ideas-subtitle">Find your next big opportunity to support or join.</p>

        @if (session('success'))
            <div class="ideas-flash">{{ session('success') }}</div>
        @endif

        <div class="ideas-toolbar">
            <div class="ideas-search">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path stroke-linecap="round" d="m20 20-3.5-3.5"></path>
                </svg>
                <input x-model="search" type="text" placeholder="Search ideas...">
            </div>

            <div class="ideas-filters">
                @foreach ($categories as $category)
                    <button
                        type="button"
                        @click="activeCategory = '{{ $category }}'"
                        :class="activeCategory === '{{ $category }}' ? 'is-active' : ''"
                        class="ideas-filter"
                    >
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </div>

        @if ($ideasWithMeta->isEmpty())
            <div class="idea-empty">
                No ideas found yet.
            </div>
        @else
            <div class="ideas-grid">
                @foreach ($ideasWithMeta as $idea)
                    <article
                        class="idea-card"
                        x-data="{
                            title: @js(strtolower($idea['title'])),
                            description: @js(strtolower($idea['description'])),
                            category: @js($idea['category'])
                        }"
                        x-show="(activeCategory === 'All' || activeCategory === category) && (search.trim() === '' || title.includes(search.toLowerCase()) || description.includes(search.toLowerCase()))"
                        @click="window.location = '{{ route('ideas.show', $idea['id']) }}'"
                    >
                        <div class="idea-card__top">
                            <span class="idea-chip">{{ $idea['category'] }}</span>
                            <span class="idea-days">{{ $idea['days_left'] }} days left</span>
                        </div>

                        <h2 class="idea-name">{{ $idea['title'] }}</h2>
                        <p class="idea-description">{{ \Illuminate\Support\Str::limit($idea['description'], 120) }}</p>

                        <div class="idea-author">
                            <span class="idea-author__badge">{{ $idea['initials'] }}</span>
                            <span class="idea-author__name">{{ $idea['creator'] }}</span>
                        </div>

                        <div class="idea-money">
                            <span class="idea-money__raised">${{ number_format($idea['current_amount']) }}</span>
                            <span class="idea-money__goal">of ${{ number_format($idea['funding_goal']) }}</span>
                        </div>

                        <div class="idea-progress">
                            <div class="idea-progress__bar" style="width: {{ $idea['progress'] }}%;"></div>
                        </div>

                        <div class="idea-stats">
                            <span>{{ $idea['supporters'] }} supporters</span>
                            <span>{{ $idea['investors'] }} investors</span>
                        </div>

                        <div class="idea-actions">
                            <a href="{{ route('ideas.show', $idea['id']) }}" @click.stop class="idea-btn idea-btn--support">
                                <span>Support</span>
                            </a>
                            <a href="{{ route('ideas.show', $idea['id']) }}" @click.stop class="idea-btn idea-btn--invest">
                                <span>Invest</span>
                            </a>
                            <a href="{{ route('ideas.show', $idea['id']) }}" @click.stop class="idea-btn idea-btn--contribute">
                                <span>Contribute</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
