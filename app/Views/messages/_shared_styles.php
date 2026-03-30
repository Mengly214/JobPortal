<style>
/* ── Hero ────────────────────────────────────────────────── */
.msg-hero{background:linear-gradient(135deg,#0a1628 0%,#0a2f6e 100%);margin-top:-70px;padding-top:120px;padding-bottom:36px}
.msg-hero__inner{position:relative;z-index:2}
.msg-hero__content{display:flex;align-items:center;gap:18px;margin-top:14px;flex-wrap:wrap}
.msg-hero__avatar img,.msg-hero__avatar-init{width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,.25);flex-shrink:0}
.msg-hero__avatar-init{background:linear-gradient(135deg,#0a65cc,#14a077);display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;font-weight:800}
.msg-hero__name{font-size:24px;font-weight:800;color:#fff;margin:0 0 4px;line-height:1.2}
.msg-hero__sub{font-size:13px;color:rgba(255,255,255,.6);margin:0}
.msg-hero__sub a{transition:.15s}
.msg-hero .jg-breadcrumb{margin-bottom:0}

/* ── Section ─────────────────────────────────────────────── */
.msg-section{padding:30px 0 60px;background:#f4f6f9;min-height:calc(100vh - 260px)}

/* ── Chat wrap ───────────────────────────────────────────── */
.msg-wrap{max-width:720px;margin:0 auto;display:flex;flex-direction:column;gap:0}

/* ── Thread ──────────────────────────────────────────────── */
.msg-thread{background:#fff;border:1px solid #e0e6f0;border-radius:16px 16px 0 0;padding:24px 20px;min-height:320px;max-height:520px;overflow-y:auto;display:flex;flex-direction:column;gap:18px;scroll-behavior:smooth}

/* Empty state */
.msg-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;flex:1;color:#b0bac8;padding:40px 0;text-align:center}
.msg-empty i{font-size:44px;margin-bottom:14px;opacity:.5}
.msg-empty p{font-size:14px;max-width:280px;line-height:1.6}

/* ── Bubbles ─────────────────────────────────────────────── */
.msg-bubble{display:flex;align-items:flex-end;gap:10px;max-width:80%}
.msg-bubble--me{align-self:flex-end;flex-direction:row-reverse}
.msg-bubble--them{align-self:flex-start}

.msg-bubble__av img,.msg-bubble__av-init{width:34px;height:34px;border-radius:50%;object-fit:cover;flex-shrink:0}
.msg-bubble__av-init{background:linear-gradient(135deg,#0a65cc,#14a077);display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700}

.msg-bubble__body{display:flex;flex-direction:column;gap:4px}
.msg-bubble__text{padding:11px 15px;border-radius:16px;font-size:14px;line-height:1.6;word-break:break-word;white-space:pre-wrap}
.msg-bubble--them .msg-bubble__text{background:#f0f4fb;color:#1a1a2e;border-bottom-left-radius:4px}
.msg-bubble--me   .msg-bubble__text{background:#0a65cc;color:#fff;border-bottom-right-radius:4px}

.msg-bubble__meta{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:4px}
.msg-bubble--me .msg-bubble__meta{justify-content:flex-end}

/* ── Compose bar ─────────────────────────────────────────── */
.msg-compose{display:flex;align-items:flex-end;gap:0;background:#fff;border:1px solid #e0e6f0;border-top:none;border-radius:0 0 16px 16px;padding:12px 14px;gap:10px}
.msg-compose__input{flex:1;border:1.5px solid #e0e6f0;border-radius:10px;padding:10px 14px;font-size:14px;font-family:inherit;resize:none;outline:none;line-height:1.5;max-height:120px;overflow-y:auto;transition:.2s}
.msg-compose__input:focus{border-color:#0a65cc;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
.msg-compose__send{width:44px;height:44px;border-radius:10px;background:#0a65cc;color:#fff;border:none;display:flex;align-items:center;justify-content:center;font-size:16px;cursor:pointer;flex-shrink:0;transition:.2s}
.msg-compose__send:hover{background:#084fa3}

/* ── Mobile ──────────────────────────────────────────────── */
@media(max-width:767px){
    .msg-hero{padding-top:100px;padding-bottom:24px}
    .msg-hero__name{font-size:18px}
    .msg-thread{max-height:360px;padding:16px 12px}
    .msg-bubble{max-width:90%}
}
</style>

<script>
/* Auto-scroll to bottom on load */
(function(){
    var t = document.getElementById('msg-thread');
    if (t) t.scrollTop = t.scrollHeight;

    /* Auto-grow textarea */
    var ta = document.querySelector('.msg-compose__input');
    if (ta) {
        ta.addEventListener('input', function(){
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
        /* Submit on Ctrl/Cmd+Enter */
        ta.addEventListener('keydown', function(e){
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }
})();
</script>