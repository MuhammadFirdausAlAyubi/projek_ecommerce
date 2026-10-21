{{-- Style bersama untuk halaman akun & alamat ELECTROMART --}}
<style>
    :root {
        --em-blue: #2563eb;
        --em-blue-dark: #1d4ed8;
        --em-soft: #eaf1ff;
        --em-ink: #0f172a;
        --em-muted: #64748b;
        --em-line: #e3eaf6;
    }

    /* ---------- Hero ---------- */
    .em-hero {
        position: relative;
        overflow: hidden;
        padding: 2rem 2.25rem;
        border-radius: 24px;
        color: #fff;
        background: linear-gradient(120deg, #0f1b45 0%, #1e40af 55%, #3b82f6 100%);
        box-shadow: 0 22px 44px -24px rgba(37, 99, 235, .7);
    }
    .em-hero::before,
    .em-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
        pointer-events: none;
    }
    .em-hero::before { width: 320px; height: 320px; top: -140px; right: -60px; }
    .em-hero::after  { width: 200px; height: 200px; bottom: -110px; right: 22%; }
    .em-hero > * { position: relative; z-index: 1; }
    .em-hero h1 { font-weight: 800; letter-spacing: -.02em; }
    .em-hero p  { color: rgba(255, 255, 255, .82); }

    @media (max-width: 575.98px) {
        .em-hero { padding: 1.5rem 1.25rem; border-radius: 20px; }
    }

    /* ---------- Buttons ---------- */
    .em-btn-glass,
    .em-btn-primary,
    .em-btn-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        font-weight: 700;
        text-decoration: none;
        border-radius: 14px;
        transition: transform .15s ease, box-shadow .15s ease, background .2s ease;
    }
    .em-btn-glass {
        padding: .65rem 1.15rem;
        color: #fff;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .3);
        backdrop-filter: blur(4px);
    }
    .em-btn-glass:hover { background: rgba(255, 255, 255, .24); color: #fff; }

    .em-btn-primary {
        padding: .8rem 1.6rem;
        color: #fff;
        border: 0;
        background: linear-gradient(135deg, var(--em-blue), #3b82f6);
        box-shadow: 0 12px 24px -12px rgba(37, 99, 235, .8);
    }
    .em-btn-primary:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 16px 28px -12px rgba(37, 99, 235, .85); }

    .em-btn-ghost {
        padding: .8rem 1.4rem;
        color: #334155;
        background: #fff;
        border: 1px solid var(--em-line);
    }
    .em-btn-ghost:hover { background: #f1f5f9; color: var(--em-ink); }

    .em-btn-danger-soft {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .5rem .85rem;
        font-size: .85rem;
        font-weight: 600;
        color: #dc2626;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 12px;
        transition: background .2s ease, color .2s ease;
    }
    .em-btn-danger-soft:hover { background: #dc2626; color: #fff; }

    /* ---------- Card & section ---------- */
    .em-card {
        background: #fff;
        border: 1px solid var(--em-line);
        border-radius: 22px;
        box-shadow: 0 14px 34px -22px rgba(15, 23, 42, .28);
    }
    .em-icon-chip {
        flex-shrink: 0;
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        color: var(--em-blue);
        background: var(--em-soft);
        border-radius: 13px;
    }
    .em-icon-lg { width: 52px; height: 52px; font-size: 1.15rem; border-radius: 16px; }
    .em-section-title { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.25rem; }
    .em-section-title h2 { font-size: 1.05rem; font-weight: 800; margin: 0; color: var(--em-ink); }
    .em-section-title small { color: var(--em-muted); }

    /* ---------- Form ---------- */
    .em-form .form-label { font-size: .875rem; font-weight: 700; color: #1e293b; margin-bottom: .4rem; }
    .em-form .form-control,
    .em-form .form-select {
        padding: .78rem 1rem;
        color: var(--em-ink);
        background-color: #f8fbff;
        border: 1.5px solid #dbe4f3;
        border-radius: 13px;
        transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
    }
    .em-form .form-control::placeholder { color: #94a3b8; }
    .em-form .form-control:focus,
    .em-form .form-select:focus {
        background-color: #fff;
        border-color: var(--em-blue);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .14);
    }
    .em-form .form-select:disabled { background-color: #f1f5f9; color: #94a3b8; cursor: not-allowed; }
    .em-form .is-invalid { border-color: #ef4444 !important; }

    .em-ic { position: relative; }
    .em-ic > i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        transition: color .15s ease;
    }
    .em-ic.em-ic-top > i { top: 1.15rem; transform: none; }
    .em-ic .form-control { padding-left: 2.8rem; }
    .em-ic:focus-within > i { color: var(--em-blue); }

    .em-hint { font-size: .78rem; color: var(--em-muted); margin-top: .35rem; }

    /* ---------- Alerts ---------- */
    .em-alert {
        display: flex;
        gap: .85rem;
        padding: 1rem 1.15rem;
        border-radius: 16px;
        border: 1px solid;
    }
    .em-alert > i { margin-top: .2rem; }
    .em-alert ul { padding-left: 1.1rem; }
    .em-alert-danger  { color: #991b1b; background: #fef2f2; border-color: #fecaca; }
    .em-alert-success { color: #166534; background: #f0fdf4; border-color: #bbf7d0; }

    /* ---------- Misc ---------- */
    .em-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .65rem;
        font-size: .75rem;
        font-weight: 700;
        color: var(--em-blue-dark);
        background: var(--em-soft);
        border-radius: 999px;
    }
    .em-chip {
        padding: .28rem .7rem;
        font-size: .8rem;
        font-weight: 600;
        color: #334155;
        background: #f1f5f9;
        border-radius: 999px;
    }

    .em-empty { text-align: center; padding: 3.5rem 1.5rem; }
    .em-empty .em-empty-icon {
        display: grid;
        place-items: center;
        width: 96px;
        height: 96px;
        margin: 0 auto 1.25rem;
        font-size: 2.2rem;
        color: var(--em-blue);
        background: var(--em-soft);
        border-radius: 28px;
    }

    .em-form a:focus-visible,
    .em-btn-glass:focus-visible,
    .em-btn-primary:focus-visible,
    .em-btn-ghost:focus-visible,
    .em-btn-danger-soft:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .45);
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        .em-btn-primary, .em-btn-glass, .em-btn-ghost, .em-form .form-control { transition: none; }
        .em-btn-primary:hover { transform: none; }
    }
</style>