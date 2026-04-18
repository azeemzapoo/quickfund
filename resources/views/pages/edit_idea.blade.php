@extends('layouts.app')

@section('content')
<style>
    .idea-edit-shell {
        background: #fcfaf5;
        margin: -3rem -2rem;
        padding: 1.5rem 2rem 3rem;
        min-height: calc(100vh - 90px);
    }

    .idea-edit-wrap {
        max-width: 1180px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
        gap: 1.8rem;
    }

    .edit-panel,
    .edit-aside {
        background: #fff;
        border: 1px solid #dce4ee;
        border-radius: 24px;
        box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
    }

    .edit-panel { padding: 2rem; }
    .edit-aside { padding: 1.75rem; }

    .edit-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 1rem;
        border-radius: 999px;
        background: #ecf8f2;
        color: #2fb289;
        font-size: 0.92rem;
        font-weight: 700;
    }

    .edit-title {
        margin: 1.2rem 0 0;
        color: #102748;
        font-size: 2.65rem;
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .edit-subtitle {
        margin: 0.9rem 0 0;
        color: #6b7a96;
        font-size: 1rem;
        line-height: 1.7;
        max-width: 42rem;
    }

    .edit-grid {
        display: grid;
        gap: 1.3rem;
        margin-top: 2rem;
    }

    .edit-label {
        display: block;
        margin-bottom: 0.65rem;
        color: #102748;
        font-size: 0.97rem;
        font-weight: 700;
    }

    .edit-input,
    .edit-textarea {
        width: 100%;
        border: 1px solid #d9e1ec;
        border-radius: 18px;
        background: #fff;
        color: #42506a;
        font-size: 1rem;
        outline: none;
        transition: 0.18s ease;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
    }

    .edit-input {
        height: 56px;
        padding: 0 1rem;
    }

    .edit-textarea {
        min-height: 180px;
        resize: vertical;
        padding: 1rem;
    }

    .edit-input:focus,
    .edit-textarea:focus {
        border-color: #2fb289;
        box-shadow: 0 0 0 4px rgba(47, 178, 137, 0.12);
    }

    .edit-help {
        margin-top: 0.55rem;
        color: #6b7a96;
        font-size: 0.9rem;
    }

    .edit-error {
        margin-top: 0.55rem;
        color: #d14343;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .edit-actions {
        display: flex;
        gap: 0.9rem;
        margin-top: 0.4rem;
        flex-wrap: wrap;
    }

    .edit-primary,
    .edit-secondary {
        min-height: 52px;
        padding: 0 1.35rem;
        border-radius: 16px;
        font-size: 0.98rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .edit-primary {
        border: 0;
        background: #2fb289;
        color: #fff;
    }

    .edit-secondary {
        border: 1px solid #d9e1ec;
        background: #fff;
        color: #22314b;
    }

    .aside-title {
        margin: 0;
        color: #102748;
        font-size: 1.2rem;
        font-weight: 800;
    }

    .aside-copy {
        margin: 0.75rem 0 0;
        color: #6b7a96;
        line-height: 1.7;
        font-size: 0.96rem;
    }

    .aside-stat-grid {
        display: grid;
        gap: 0.95rem;
        margin-top: 1.5rem;
    }

    .aside-stat {
        border: 1px solid #e4ebf3;
        border-radius: 18px;
        background: #fcfaf5;
        padding: 1rem 1.05rem;
    }

    .aside-stat span {
        display: block;
        color: #6b7a96;
        font-size: 0.88rem;
        margin-bottom: 0.28rem;
    }

    .aside-stat strong {
        display: block;
        color: #102748;
        font-size: 1rem;
        font-weight: 800;
    }

    @media (max-width: 900px) {
        .idea-edit-shell {
            margin: -3rem -1rem;
            padding: 1rem 1rem 2rem;
        }

        .idea-edit-wrap {
            grid-template-columns: 1fr;
        }

        .edit-title {
            font-size: 2.1rem;
        }
    }
</style>

<div class="idea-edit-shell">
    <div class="idea-edit-wrap">
        <section class="edit-panel">
            <span class="edit-eyebrow">Edit Idea</span>
            <h1 class="edit-title">Update your idea without losing the progress you already raised.</h1>
            <p class="edit-subtitle">
                You can change the title, description, and funding goal. The funding goal cannot be lower than the amount already raised.
            </p>

            <form method="POST" action="{{ route('ideas.update', $idea->id) }}" class="edit-grid">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="edit-label">Idea Title</label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title', $idea->title) }}"
                        class="edit-input"
                        placeholder="Ex: StudySwap"
                    >
                    @error('title')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="description" class="edit-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="edit-textarea"
                        placeholder="Explain what the idea does, who it helps, and why people should support it."
                    >{{ old('description', $idea->description) }}</textarea>
                    @error('description')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="funding_goal" class="edit-label">Funding Goal</label>
                    <input
                        id="funding_goal"
                        name="funding_goal"
                        type="number"
                        min="{{ max(1, (int) $idea->current_amount) }}"
                        value="{{ old('funding_goal', $idea->funding_goal) }}"
                        class="edit-input"
                        placeholder="Ex: 5000"
                    >
                    <div class="edit-help">Minimum allowed goal right now: ${{ number_format($idea->current_amount) }} because that amount is already raised.</div>
                    @error('funding_goal')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edit-actions">
                    <button type="submit" class="edit-primary">Save Changes</button>
                    <a href="{{ route('ideas.show', $idea->id) }}" class="edit-secondary">Back to Idea</a>
                </div>
            </form>
        </section>

        <aside class="edit-aside">
            <h2 class="aside-title">Current idea snapshot</h2>
            <p class="aside-copy">
                These numbers help you update the idea safely while keeping the existing momentum.
            </p>

            <div class="aside-stat-grid">
                <div class="aside-stat">
                    <span>Current Amount Raised</span>
                    <strong>${{ number_format($idea->current_amount) }}</strong>
                </div>

                <div class="aside-stat">
                    <span>Current Funding Goal</span>
                    <strong>${{ number_format($idea->funding_goal) }}</strong>
                </div>

                <div class="aside-stat">
                    <span>Minimum Goal You Can Save</span>
                    <strong>${{ number_format($idea->current_amount) }}</strong>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
