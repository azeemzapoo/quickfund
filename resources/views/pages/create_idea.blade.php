@extends('layouts.app')

@section('content')
<style>
    .idea-create-shell {
        background: #fcfaf5;
        margin: -3rem -2rem;
        padding: 1.5rem 2rem 3rem;
        min-height: calc(100vh - 90px);
    }

    .idea-create-wrap {
        max-width: 1180px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
        gap: 1.8rem;
    }

    .idea-panel,
    .idea-aside {
        background: #fff;
        border: 1px solid #dce4ee;
        border-radius: 24px;
        box-shadow: 0 8px 24px rgba(16, 24, 40, 0.05);
    }

    .idea-panel {
        padding: 2rem;
    }

    .idea-aside {
        padding: 1.75rem;
    }

    .idea-eyebrow {
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

    .idea-title {
        margin: 1.2rem 0 0;
        color: #102748;
        font-size: 2.65rem;
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .idea-subtitle {
        margin: 0.9rem 0 0;
        color: #6b7a96;
        font-size: 1rem;
        line-height: 1.7;
        max-width: 42rem;
    }

    .form-grid {
        display: grid;
        gap: 1.3rem;
        margin-top: 2rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.65rem;
        color: #102748;
        font-size: 0.97rem;
        font-weight: 700;
    }

    .form-input,
    .form-textarea {
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

    .form-input {
        height: 56px;
        padding: 0 1rem;
    }

    .form-textarea {
        min-height: 180px;
        resize: vertical;
        padding: 1rem;
    }

    .form-input:focus,
    .form-textarea:focus {
        border-color: #2fb289;
        box-shadow: 0 0 0 4px rgba(47, 178, 137, 0.12);
    }

    .field-help {
        margin-top: 0.55rem;
        color: #6b7a96;
        font-size: 0.9rem;
    }

    .field-error {
        margin-top: 0.55rem;
        color: #d14343;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .actions-row {
        display: flex;
        gap: 0.9rem;
        margin-top: 0.4rem;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-secondary {
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

    .btn-primary {
        border: 0;
        background: #2fb289;
        color: #fff;
    }

    .btn-secondary {
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

    .aside-list {
        display: grid;
        gap: 1rem;
        margin: 1.5rem 0 0;
    }

    .aside-item {
        display: grid;
        grid-template-columns: 38px 1fr;
        gap: 0.9rem;
        align-items: start;
    }

    .aside-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
    }

    .aside-icon.green { background: #2fb289; }
    .aside-icon.purple { background: #6a5ae0; }
    .aside-icon.blue { background: #2d9cdb; }

    .aside-item strong {
        display: block;
        color: #102748;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .aside-item span {
        color: #6b7a96;
        font-size: 0.92rem;
        line-height: 1.6;
    }

    @media (max-width: 900px) {
        .idea-create-shell {
            margin: -3rem -1rem;
            padding: 1rem 1rem 2rem;
        }

        .idea-create-wrap {
            grid-template-columns: 1fr;
        }

        .idea-title {
            font-size: 2.1rem;
        }
    }
</style>

<div class="idea-create-shell">
    <div class="idea-create-wrap">
        <section class="idea-panel">
            <span class="idea-eyebrow">Create Idea</span>
            <h1 class="idea-title">Turn your idea into a page others can support.</h1>
            <p class="idea-subtitle">
                Share a clear title, explain the problem you are solving, and set a funding goal.
                Keep the same clean QuickFund style your ideas page already uses.
            </p>

            <form method="POST" action="{{ route('ideas.store') }}" class="form-grid">
                @csrf

                <div>
                    <label for="title" class="form-label">Idea Title</label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title') }}"
                        class="form-input"
                        placeholder="Ex: StudySwap"
                    >
                    <div class="field-help">Choose a short, memorable name for your project.</div>
                    @error('title')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-textarea"
                        placeholder="Explain what the idea does, who it helps, and why people should join or support it."
                    >{{ old('description') }}</textarea>
                    <div class="field-help">Aim for a clear explanation that is easy to read on the explore page.</div>
                    @error('description')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="funding_goal" class="form-label">Funding Goal</label>
                    <input
                        id="funding_goal"
                        name="funding_goal"
                        type="number"
                        min="1"
                        value="{{ old('funding_goal') }}"
                        class="form-input"
                        placeholder="Ex: 5000"
                    >
                    <div class="field-help">Enter the total amount you want to raise for this idea.</div>
                    @error('funding_goal')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions-row">
                    <button type="submit" class="btn-primary">Publish Idea</button>
                    <a href="{{ route('ideas.index') }}" class="btn-secondary">Back to Ideas</a>
                </div>
            </form>
        </section>

        <aside class="idea-aside">
            <h2 class="aside-title">What makes a strong idea page?</h2>
            <p class="aside-copy">
                The best QuickFund ideas are easy to understand at a glance and give supporters confidence.
            </p>

            <div class="aside-list">
                <div class="aside-item">
                    <span class="aside-icon green">1</span>
                    <div>
                        <strong>Clear title</strong>
                        <span>Use a simple name that instantly tells people what the idea is about.</span>
                    </div>
                </div>

                <div class="aside-item">
                    <span class="aside-icon purple">2</span>
                    <div>
                        <strong>Focused description</strong>
                        <span>Explain the problem, the audience, and the value of the idea in plain language.</span>
                    </div>
                </div>

                <div class="aside-item">
                    <span class="aside-icon blue">3</span>
                    <div>
                        <strong>Realistic goal</strong>
                        <span>Set a funding amount that makes sense for the stage of your project.</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
