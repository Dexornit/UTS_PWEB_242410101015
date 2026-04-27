<footer class="site-footer">
    <div class="footer-inner">
        <p>
            <i class="far fa-copyright"></i>
            {{ date('Y') }} <strong>Dexornit</strong>. All rights reserved.
        </p>
    </div>
</footer>

<style>
.site-footer {
    background: #fff;
    border-top: 1px solid #dde8de;
    padding: 18px 0;
    margin-top: auto;
}

.footer-inner {
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
    text-align: center;
}

.footer-inner p {
    font-size: 0.82rem;
    color: #6b7f6c;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.footer-inner p i {
    color: #9bcba3;
}

.footer-inner strong {
    color: #3a7347;
}
</style>
