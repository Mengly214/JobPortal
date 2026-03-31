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
.msg-wrap{max-width:720px;margin:0 auto;display:flex;flex-direction:column}

/* ── Thread ──────────────────────────────────────────────── */
.msg-thread{background:#fff;border:1px solid #e0e6f0;border-radius:16px 16px 0 0;padding:24px 20px;min-height:320px;max-height:520px;overflow-y:auto;display:flex;flex-direction:column;gap:18px;scroll-behavior:smooth}

/* Typing / polling indicator */
.msg-typing{display:none;align-self:flex-start;align-items:center;gap:8px;padding:8px 14px;background:#f0f4fb;border-radius:16px;border-bottom-left-radius:4px;font-size:12px;color:#94a3b8}
.msg-typing.visible{display:flex}
.msg-typing__dots{display:flex;gap:3px}
.msg-typing__dots span{width:6px;height:6px;border-radius:50%;background:#b0bac8;animation:typingDot 1.2s infinite}
.msg-typing__dots span:nth-child(2){animation-delay:.2s}
.msg-typing__dots span:nth-child(3){animation-delay:.4s}
@keyframes typingDot{0%,80%,100%{transform:scale(.8);opacity:.5}40%{transform:scale(1);opacity:1}}

/* Empty state */
.msg-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;flex:1;color:#b0bac8;padding:40px 0;text-align:center}
.msg-empty i{font-size:44px;margin-bottom:14px;opacity:.5}
.msg-empty p{font-size:14px;max-width:280px;line-height:1.6}

/* ── Bubbles ─────────────────────────────────────────────── */
.msg-bubble{display:flex;align-items:flex-end;gap:10px;max-width:80%;animation:bubbleIn .2s ease}
@keyframes bubbleIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
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

/* ── Status bar (live indicator) ────────────────────────── */
.msg-statusbar{display:flex;align-items:center;gap:6px;padding:6px 20px;background:#f8fafc;border-left:1px solid #e0e6f0;border-right:1px solid #e0e6f0;font-size:11px;color:#94a3b8;min-height:28px}
.msg-statusbar__dot{width:7px;height:7px;border-radius:50%;background:#d0daea;flex-shrink:0;transition:.3s}
.msg-statusbar__dot--live{background:#14a077;animation:livePulse 2s infinite}
@keyframes livePulse{0%,100%{opacity:1}50%{opacity:.4}}

/* ── Compose bar ─────────────────────────────────────────── */
.msg-compose{display:flex;align-items:flex-end;gap:10px;background:#fff;border:1px solid #e0e6f0;border-top:none;border-radius:0 0 16px 16px;padding:12px 14px}
.msg-compose__input{flex:1;border:1.5px solid #e0e6f0;border-radius:10px;padding:10px 14px;font-size:14px;font-family:inherit;resize:none;outline:none;line-height:1.5;max-height:120px;overflow-y:auto;transition:.2s}
.msg-compose__input:focus{border-color:#0a65cc;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
.msg-compose__send{width:44px;height:44px;border-radius:10px;background:#0a65cc;color:#fff;border:none;display:flex;align-items:center;justify-content:center;font-size:16px;cursor:pointer;flex-shrink:0;transition:.2s}
.msg-compose__send:hover{background:#084fa3}
.msg-compose__send:disabled{background:#c0cad8;cursor:not-allowed}

/* ── Mobile ──────────────────────────────────────────────── */
@media(max-width:767px){
    .msg-hero{padding-top:100px;padding-bottom:24px}
    .msg-hero__name{font-size:18px}
    .msg-thread{max-height:360px;padding:16px 12px}
    .msg-bubble{max-width:90%}
}
</style>

<script>
(function () {

    var thread   = document.getElementById('msg-thread');
    var form     = document.querySelector('.msg-compose');
    var textarea = document.querySelector('.msg-compose__input');
    var sendBtn  = document.querySelector('.msg-compose__send');
    var statusDot= document.querySelector('.msg-statusbar__dot');
    var statusTxt= document.querySelector('.msg-statusbar__text');

    var APP_ID   = parseInt(document.getElementById('msg-app-id').value, 10);
    var API_BASE = document.getElementById('msg-api-base').value;
    var lastId   = parseInt(document.getElementById('msg-last-id').value, 10) || 0;
    var polling  = null;
    var INTERVAL = 3000; // poll every 3 seconds

    /* ── Helpers ───────────────────────────────────────── */
    function scrollBottom(smooth) {
        if (!thread) return;
        thread.scrollTo({ top: thread.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
    }

    function setStatus(live, text) {
        if (statusDot) {
            statusDot.classList.toggle('msg-statusbar__dot--live', live);
        }
        if (statusTxt) statusTxt.textContent = text;
    }

    function removeEmpty() {
        var empty = thread.querySelector('.msg-empty');
        if (empty) empty.remove();
    }

    function appendBubbles(html) {
        if (!html) return;
        var near = thread.scrollHeight - thread.scrollTop - thread.clientHeight < 80;
        var div  = document.createElement('div');
        div.innerHTML = html;
        while (div.firstChild) thread.appendChild(div.firstChild);
        if (near) scrollBottom(true);
    }

    /* ── Auto-grow textarea ────────────────────────────── */
    if (textarea) {
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }

    /* ── Send via AJAX ─────────────────────────────────── */
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var msg = textarea.value.trim();
            if (!msg) return;

            sendBtn.disabled = true;
            var body = new FormData();
            body.append('message', msg);

            fetch(API_BASE + '/' + APP_ID, { method: 'POST', body: body })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.html) {
                        removeEmpty();
                        appendBubbles(data.html);
                        lastId = Math.max(lastId, data.lastId || 0);
                        document.getElementById('msg-last-id').value = lastId;
                    }
                    textarea.value = '';
                    textarea.style.height = 'auto';
                })
                .catch(function () {
                    setStatus(false, 'Send failed — check your connection');
                })
                .finally(function () {
                    sendBtn.disabled = false;
                    textarea.focus();
                });
        });

        /* Ctrl/Cmd+Enter shortcut */
        textarea.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                form.dispatchEvent(new Event('submit'));
            }
        });
    }

    /* ── Polling ───────────────────────────────────────── */
    function poll() {
        fetch(API_BASE + '/' + APP_ID + '?after=' + lastId)
            .then(function (r) {
                if (!r.ok) throw new Error('poll failed');
                return r.json();
            })
            .then(function (data) {
                setStatus(true, 'Live');
                if (data.count > 0) {
                    removeEmpty();
                    appendBubbles(data.html);
                    lastId = data.lastId;
                    document.getElementById('msg-last-id').value = lastId;
                }
            })
            .catch(function () {
                setStatus(false, 'Reconnecting…');
            });
    }

    /* Start polling */
    scrollBottom(false);
    polling = setInterval(poll, INTERVAL);

    /* Pause when tab is hidden, resume when visible */
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            clearInterval(polling);
            setStatus(false, 'Paused');
        } else {
            poll(); // immediate catch-up
            polling = setInterval(poll, INTERVAL);
        }
    });

})();
</script>