<section class="notice-section">
    <div class="container">
        <div class="notice-section-wrapper">
            <marquee behavior="scroll" direction="left" onmouseover="this.stop()" onmouseout="this.start()">
                <span class="px-4"><b>{{ $notice->headline ?? '' }}:&nbsp;</b>{{ $notice->description ?? '' }}</span>
            </marquee>
        </div>
    </div>
</section>
