<?php
// =============================================
// FOOTER PARTIAL
// =============================================
$settings = getAllSettings();
$footerText = $settings['footer_text'] ?? 'Building premium digital experiences.';
$footerEmail = $settings['footer_email'] ?? 'hello@alenmodwebhub.com';
$copyright = $settings['copyright_text'] ?? '© 2024 Alenmodwebhub. All rights reserved.';
$github = $settings['github_url'] ?? '#';
$linkedin = $settings['linkedin_url'] ?? '#';
$twitter = $settings['twitter_url'] ?? '#';
$facebook = $settings['facebook_url'] ?? '#';
$instagram = $settings['instagram_url'] ?? '#';
$youtube = $settings['youtube_url'] ?? '#';
?>
    <!-- Footer -->
    <footer class="footer" id="footer">
        <div class="footer-grid">
            <div>
                <a href="#hero" class="nav-logo">Alenmodwebhub</a>
                <p class="footer-brand-desc"><?php echo htmlspecialchars($footerText); ?></p>
                <div class="footer-social">
                    <a href="<?php echo htmlspecialchars($github); ?>" class="footer-social-link" target="_blank" rel="noopener" aria-label="GitHub">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                    </a>
                    <a href="<?php echo htmlspecialchars($linkedin); ?>" class="footer-social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="<?php echo htmlspecialchars($twitter); ?>" class="footer-social-link" target="_blank" rel="noopener" aria-label="Twitter">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="<?php echo htmlspecialchars($instagram); ?>" class="footer-social-link" target="_blank" rel="noopener" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 100-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 11-2.882 0 1.441 1.441 0 012.882 0z"/></svg>
                    </a>
                    <a href="<?php echo htmlspecialchars($youtube); ?>" class="footer-social-link" target="_blank" rel="noopener" aria-label="YouTube">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="footer-heading">Quick Links</h4>
                <div class="footer-links">
                    <a href="#hero" class="footer-link">Home</a>
                    <a href="#about" class="footer-link">About Me</a>
                    <a href="#services" class="footer-link">Services</a>
                    <a href="#projects" class="footer-link">Projects</a>
                    <a href="#testimonials" class="footer-link">Testimonials</a>
                    <a href="#blog" class="footer-link">Blog</a>
                    <a href="#contact" class="footer-link">Contact</a>
                </div>
            </div>

            <div>
                <h4 class="footer-heading">Services</h4>
                <div class="footer-links">
                    <?php
                    $footerServices = getServices();
                    $count = 0;
                    foreach ($footerServices as $svc):
                        if ($count >= 5) break;
                        $count++;
                    ?>
                    <a href="#services" class="footer-link"><?php echo htmlspecialchars($svc['title']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h4 class="footer-heading">Stay Updated</h4>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1rem; line-height: 1.6;">
                    Subscribe for updates on new projects, blog posts, and tech insights.
                </p>
                <form id="newsletterForm" class="footer-newsletter">
                    <input type="email" name="email" placeholder="Your email" required>
                    <button type="submit">Join</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <span><?php echo htmlspecialchars($copyright); ?></span>
            <span>Built with ❤️ by Alenmodwebhub</span>
        </div>
    </footer>

    <!-- Back to Top -->
    <button class="back-to-top" aria-label="Back to top">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </button>

    <!-- Live Chat Widget -->
    <?php
    $tg = $settings['telegram_chat'] ?? '';
    $wa = ltrim($settings['whatsapp'] ?? '2348012345678', '+');
    $tgLink = '';
    if (!empty($tg)) {
        $tgLink = strpos($tg, 'http') === 0 ? $tg : 'https://t.me/' . ltrim($tg, '@');
    }
    ?>
    <div class="chat-widget" id="chatWidget">
        <button class="chat-toggle" id="chatToggle" aria-label="Open chat">
            <svg class="chat-icon-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            <svg class="chat-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <div class="chat-panel" id="chatPanel">
            <div class="chat-header">
                <div class="chat-header-title">Chat with Me</div>
                <div class="chat-header-sub">Type your message and choose a platform</div>
            </div>
            <div class="chat-body">
                <textarea class="chat-input" id="chatMessage" placeholder="Write your message here..." rows="3"></textarea>
                <div class="chat-buttons">
                    <?php if (!empty($tgLink)): ?>
                    <button class="chat-btn chat-btn-tg" onclick="sendChat('tg')" id="chatBtnTg">
                        <span class="chat-btn-icon">✈</span> Telegram
                    </button>
                    <?php endif; ?>
                    <button class="chat-btn chat-btn-wa" onclick="sendChat('wa')" id="chatBtnWa">
                        <span class="chat-btn-icon">💬</span> WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
    .chat-widget { position:fixed; bottom:90px; right:20px; z-index:9999; display:flex; flex-direction:column; align-items:flex-end; }
    .chat-toggle { width:56px; height:56px; border-radius:50%; border:none; background:#6366f1; color:white; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 20px rgba(99,102,241,0.4); transition:all 0.3s ease; }
    .chat-toggle:hover { transform:scale(1.1); box-shadow:0 6px 25px rgba(99,102,241,0.5); }
    .chat-toggle .chat-icon-close { display:none; }
    .chat-widget.open .chat-toggle .chat-icon-open { display:none; }
    .chat-widget.open .chat-toggle .chat-icon-close { display:block; }
    .chat-panel { display:none; position:absolute; bottom:66px; right:0; width:320px; background:#1a1a30; border:1px solid #2a2a50; border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.5); animation:chatSlideUp 0.3s ease; }
    .chat-widget.open .chat-panel { display:block; }
    @keyframes chatSlideUp { from { opacity:0; transform:translateY(20px) scale(0.95); } to { opacity:1; transform:translateY(0) scale(1); } }
    .chat-header { padding:16px 20px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; }
    .chat-header-title { font-size:1rem; font-weight:700; }
    .chat-header-sub { font-size:0.8rem; opacity:0.85; margin-top:2px; }
    .chat-body { padding:12px; display:flex; flex-direction:column; gap:10px; }
    .chat-input { width:100%; padding:10px 12px; border-radius:10px; border:1px solid #2a2a50; background:#12122a; color:#f0f0f5; font-size:0.9rem; font-family:inherit; resize:none; outline:none; box-sizing:border-box; transition:border 0.2s; }
    .chat-input:focus { border-color:#6366f1; }
    .chat-input::placeholder { color:#6666aa; }
    .chat-buttons { display:flex; gap:8px; }
    .chat-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:6px; padding:10px; border-radius:10px; border:none; font-size:0.85rem; font-weight:600; cursor:pointer; transition:all 0.2s; color:white; text-decoration:none; }
    .chat-btn:hover { transform:translateY(-1px); }
    .chat-btn-tg { background:#0088cc; }
    .chat-btn-tg:hover { background:#0077b3; }
    .chat-btn-wa { background:#25D366; }
    .chat-btn-wa:hover { background:#1ebe5d; }
    .chat-btn-icon { font-size:1rem; }
    </style>

    <script>
    var _chatTg = <?php echo json_encode($tgLink) ?: "''"; ?>;
    var _chatWa = <?php echo json_encode($wa) ?: "''"; ?>;
    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.getElementById('chatToggle');
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                document.getElementById('chatWidget').classList.toggle('open');
            });
            document.addEventListener('click', function(e) {
                var widget = document.getElementById('chatWidget');
                if (widget && widget.classList.contains('open') && !widget.contains(e.target)) {
                    widget.classList.remove('open');
                }
            });
        }
    });
    function sendChat(platform) {
        var msg = document.getElementById('chatMessage').value.trim();
        if (!msg) { document.getElementById('chatMessage').focus(); return; }
        var encoded = encodeURIComponent(msg);
        var url = '';
        if (platform === 'tg' && _chatTg) {
            url = _chatTg + '?text=' + encoded;
        } else if (platform === 'wa' && _chatWa) {
            url = 'https://wa.me/' + _chatWa + '?text=' + encoded;
        }
        if (url) window.open(url, '_blank');
    }
    </script>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
