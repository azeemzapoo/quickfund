@extends('layouts.app')

@section('content')
<style>
    .home-shell {
        background: #fcfaf5;
        margin: -3rem -2rem;
        padding: 1.75rem 2rem 3rem;
        min-height: calc(100vh - 90px);
    }

    .home-wrap {
        max-width: 1300px;
        margin: 0 auto;
    }

    .home-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.02fr) minmax(430px, 0.98fr);
        gap: 2.6rem;
        align-items: center;
        padding-top: 1.4rem;
    }

    .home-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        border-radius: 999px;
        background: #eaf6ef;
        color: #2fb289;
        padding: 0.78rem 1.35rem;
        font-size: 0.92rem;
        font-weight: 700;
        line-height: 1;
    }

    .home-title {
        margin: 1.75rem 0 0;
        color: #182233;
        font-size: 4.65rem;
        line-height: 0.96;
        font-weight: 800;
        letter-spacing: -0.05em;
        max-width: 720px;
    }

    .home-title .accent {
        color: #2fb289;
    }

    .home-copy {
        margin: 1.6rem 0 0;
        max-width: 680px;
        color: #677893;
        font-size: 1.05rem;
        line-height: 1.8;
    }

    .home-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .home-btn,
    .home-btn-secondary {
        min-height: 54px;
        padding: 0 1.45rem;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        text-decoration: none;
        font-size: 0.98rem;
        font-weight: 700;
    }

    .home-btn {
        background: #2fb289;
        color: #fff;
    }

    .home-btn-secondary {
        border: 1px solid #d8e0eb;
        background: #fff;
        color: #182233;
    }

    .home-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.25rem;
        margin-top: 2.6rem;
        max-width: 500px;
    }

    .home-stat {
        display: grid;
        gap: 0.3rem;
    }

    .home-stat__icon {
        color: #2fb289;
    }

    .home-stat__value {
        color: #182233;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .home-stat__label {
        color: #6b7a96;
        font-size: 0.9rem;
    }

    .home-visual {
        position: relative;
        min-height: 540px;
        display: flex;
        align-items: center;
    }

    .home-visual-card {
        width: 100%;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #d7eadf;
        background: linear-gradient(180deg, #d2f0e0 0%, #dff4e8 35%, #f9f0cf 100%);
        box-shadow: 0 20px 45px rgba(21, 33, 53, 0.09);
    }

    .home-visual svg {
        width: 100%;
        height: auto;
        display: block;
    }

    @media (max-width: 1100px) {
        .home-hero {
            grid-template-columns: 1fr;
        }

        .home-title {
            font-size: 3.7rem;
            max-width: 640px;
        }

        .home-visual {
            min-height: auto;
        }
    }

    @media (max-width: 768px) {
        .home-shell {
            margin: -3rem -1rem;
            padding: 1rem 1rem 2rem;
        }

        .home-title {
            font-size: 2.95rem;
        }

        .home-stats {
            grid-template-columns: 1fr;
            max-width: 220px;
        }
    }
</style>

<div class="home-shell">
    <div class="home-wrap">
        <section class="home-hero">
            <div>
                <span class="home-badge">🚀 Micro-Crowdfunding for Students</span>

                <h1 class="home-title">
                    Validate Your Ideas.
                    <span class="accent">Build With Others.</span>
                </h1>

                <p class="home-copy">
                    Post your startup idea, get micro-funding from peers, and find collaborators who believe in your vision. All within your campus community.
                </p>

                <div class="home-actions">
                    <a href="{{ route('ideas.index') }}" class="home-btn">
                        Explore Ideas
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('ideas.create') }}" class="home-btn-secondary">Post Your Idea</a>
                </div>

                <div class="home-stats">
                    <div class="home-stat">
                        <div class="home-stat__icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12c1.5-3 4.5-7 7-7 1.5 0 2.3 1 2.3 2.1 0 1.5-1.3 2.9-2.9 2.9h-1.1c-1.8 0-3.3 1.4-3.3 3.2 0 1.7 1.3 3 3 3 2.2 0 3.7-1.8 4.7-3.6L19 7"></path>
                            </svg>
                        </div>
                        <div class="home-stat__value">240+</div>
                        <div class="home-stat__label">Ideas launched</div>
                    </div>

                    <div class="home-stat">
                        <div class="home-stat__icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="home-stat__value">1.2k</div>
                        <div class="home-stat__label">Active students</div>
                    </div>

                    <div class="home-stat">
                        <div class="home-stat__icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17 9 11l4 4 8-8"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 7h7v7"></path>
                            </svg>
                        </div>
                        <div class="home-stat__value">$82k</div>
                        <div class="home-stat__label">Community backing</div>
                    </div>
                </div>
            </div>

            <div class="home-visual">
                <div class="home-visual-card">
                    <svg viewBox="0 0 720 540" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <defs>
                            <linearGradient id="bgHome" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#d4efe1"/>
                                <stop offset="60%" stop-color="#d9f2e5"/>
                                <stop offset="100%" stop-color="#fff6dd"/>
                            </linearGradient>
                        </defs>

                        <rect width="720" height="540" rx="30" fill="url(#bgHome)"/>
                        <ellipse cx="375" cy="330" rx="268" ry="186" fill="#fff6df"/>
                        <ellipse cx="376" cy="505" rx="285" ry="22" fill="#e8dcc1"/>

                        <circle cx="390" cy="126" r="44" fill="#ffe286"/>
                        <circle cx="390" cy="126" r="25" fill="#fff3bf"/>
                        <path d="M390 77v-20M425 90l13-8M355 90l-13-8M353 125l-17 1M444 125l17 1M365 160l-13 8M416 160l13 8" stroke="#f2ba46" stroke-width="3" stroke-linecap="round"/>
                        <path d="M377 117h26l-9 27h-8l-9-27Z" fill="#f6cd5c"/>
                        <rect x="382" y="144" width="17" height="30" rx="7" fill="#2f284f"/>
                        <rect x="372" y="172" width="37" height="11" rx="5.5" fill="#3f3967"/>

                        <path d="M255 145 308 189l84-48 102 79 94-84" fill="none" stroke="#d6934a" stroke-width="2.5"/>
                        <circle cx="255" cy="145" r="13" fill="#ffbf48"/>
                        <circle cx="308" cy="189" r="12" fill="#ff9a45"/>
                        <circle cx="392" cy="141" r="12" fill="#ffbf48"/>
                        <circle cx="494" cy="220" r="10" fill="#ff8d43"/>
                        <circle cx="588" cy="136" r="11" fill="#4ec7c2"/>

                        <circle cx="314" cy="171" r="10" fill="#ffb74d"/>
                        <circle cx="545" cy="274" r="17" fill="#ffb648"/>
                        <circle cx="516" cy="206" r="20" fill="#ff8250"/>
                        <circle cx="645" cy="120" r="18" fill="#ff9146"/>

                        <path d="M635 120h10c3 0 6 3 6 6 0 3-3 6-6 6h-10v-12Zm0 12h12c3 0 6 3 6 6 0 4-3 6-6 6h-12v-12Z" fill="none" stroke="#fff" stroke-width="2"/>
                        <path d="M540 270c0-5 8-5 8 0s-8 5-8 10 8 5 8 0" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round"/>
                        <path d="M509 200h14M516 193v14" stroke="#fff" stroke-width="2.4" stroke-linecap="round"/>
                        <path d="M555 205 516 205M588 136 644 120M546 274 516 206" stroke="#dd9d58" stroke-width="2"/>

                        <path d="M165 468c13-88 52-168 113-168 36 0 58 20 83 56 21 29 43 55 90 55 45 0 76-29 101-62 23-32 45-49 78-49 58 0 95 64 107 168" fill="#fff2d8"/>

                        <rect x="305" y="360" width="170" height="14" rx="7" fill="#f58a3a"/>
                        <path d="M326 372 309 465M454 372 472 465" stroke="#ae6d43" stroke-width="6" stroke-linecap="round"/>

                        <rect x="415" y="344" width="16" height="28" rx="3" fill="#f7cf5c"/>
                        <rect x="433" y="349" width="16" height="23" rx="3" fill="#f4bb3b"/>
                        <rect x="451" y="354" width="16" height="18" rx="3" fill="#f7cf5c"/>

                        <path d="M187 432c0 26 18 46 41 46s42-20 42-46v-9h-83v9Z" fill="#ff9551"/>
                        <path d="M188 361c0-39 22-74 55-74 31 0 54 27 54 66 0 17-5 31-9 43l-93-5c-4-11-7-19-7-30Z" fill="#2d7b76"/>
                        <circle cx="242" cy="248" r="33" fill="#2f294f"/>
                        <path d="M207 264c4-31 24-48 52-48 18 0 31 9 40 24-3 31-24 56-59 56-16 0-25-9-33-32Z" fill="#2f294f"/>
                        <path d="M210 282c0-24 15-45 37-45 23 0 39 19 39 44 0 26-16 44-39 44-22 0-37-17-37-43Z" fill="#ffd5c1"/>

                        <circle cx="357" cy="277" r="31" fill="#935e58"/>
                        <path d="M324 290c4-27 22-44 46-44 23 0 40 18 40 44 0 3 0 6-1 10-12 14-28 20-47 20-20 0-33-8-38-30Z" fill="#935e58"/>
                        <path d="M332 304c0-25 15-45 38-45 24 0 40 20 40 44 0 25-17 43-40 43-22 0-38-16-38-42Z" fill="#ffd5c1"/>
                        <path d="M344 346c16 0 29 8 39 31l20 42h-73l-17-39c-10-26 0-34 31-34Z" fill="#ffb24d"/>
                        <path d="M401 393 430 363" stroke="#ffb24d" stroke-width="13" stroke-linecap="round"/>

                        <circle cx="593" cy="286" r="29" fill="#ff7f4b"/>
                        <path d="M562 299c5-25 22-43 45-43 17 0 31 8 39 21-2 29-20 51-48 51-18 0-29-9-36-29Z" fill="#ff7f4b"/>
                        <path d="M569 313c0-26 15-47 38-47 24 0 40 21 40 46 0 26-16 46-40 46-22 0-38-17-38-45Z" fill="#ffd5c1"/>
                        <path d="M576 356c14 0 28 9 36 28l16 39h-68l-10-37c-7-24 2-30 26-30Z" fill="#2e8276"/>
                        <path d="M635 430c0 27-18 48-41 48s-42-21-42-48h83Z" fill="#9fbe63"/>

                        <rect x="500" y="350" width="50" height="34" rx="5" fill="#7fd9d5"/>
                        <path d="M498 386h55" stroke="#5bb7b3" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
