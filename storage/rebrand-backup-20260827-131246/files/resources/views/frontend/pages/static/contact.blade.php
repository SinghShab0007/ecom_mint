<style>
    .info-tile{background:#fff;border:1px solid #eceef3;border-radius:12px;padding:22px;height:100%;transition:.25s;}
    .info-tile:hover{box-shadow:0 10px 28px rgba(10,11,46,.09);transform:translateY(-3px);}
    .info-tile .ic{width:46px;height:46px;border-radius:50%;background:#4C1D6B14;color:#4C1D6B;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:14px;}
    .info-tile h6{color:#0A0B2E;font-weight:600;margin-bottom:8px;}
    .info-tile p{color:#6b7280;font-size:14px;margin:0;line-height:1.7;}
    .info-tile a{color:#4C1D6B;text-decoration:none;}
    .contact-card{background:#fff;border:1px solid #eceef3;border-radius:14px;padding:32px;}
    .contact-card h4{color:#0A0B2E;font-weight:700;margin-bottom:6px;}
    .contact-card .sub{color:#6b7280;font-size:14px;margin-bottom:26px;}
    .form-label{color:#0A0B2E;font-weight:500;font-size:14px;margin-bottom:6px;}
    .form-control{border:1px solid #e3e6ee;border-radius:9px;padding:11px 14px;font-size:14px;box-shadow:none;}
    .form-control:focus{border-color:#4C1D6B;box-shadow:0 0 0 3px #4C1D6B1f;}
    .btn-send{background:#4C1D6B;color:#fff;border:0;border-radius:9px;padding:12px 34px;font-weight:600;transition:.25s;}
    .btn-send:hover{background:#a92457;color:#fff;}
    .support-strip{background:#f7f8fc;border-radius:12px;padding:26px;}
    .support-strip li{color:#6b7280;font-size:14px;margin-bottom:9px;}
    .support-strip li:last-child{margin-bottom:0;}
    .alert-ok{background:#e8f7ee;border:1px solid #b7e4c7;color:#1b6b3a;border-radius:10px;padding:14px 18px;font-size:14px;}
</style>

<section class="py-5" style="background:#fff;">
    <div class="container">

        {{-- INFO TILES --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-tile">
                    <div class="ic">&#9742;</div>
                    <h6>Call Us</h6>
                    <p>
                        <a href="tel:+919528070571">+91 9528070571</a><br>
                        Monday – Saturday, 10:00 AM – 7:00 PM
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-tile">
                    <div class="ic">&#9993;</div>
                    <h6>Email Us</h6>
                    <p>
                        <a href="mailto:porosshoppvtltd@gmail.com">porosshoppvtltd@gmail.com</a><br>
                        We usually reply within 24 hours.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-tile">
                    <div class="ic">&#9873;</div>
                    <h6>Visit Us</h6>
                    <p>
                        Office No. D-242, Sector 63,<br>
                        Noida, Gautam Buddha Nagar,<br>
                        Uttar Pradesh 201307
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- CONTACT FORM --}}
            <div class="col-lg-7">
                <div class="contact-card" id="contact-form">
                    <h4>Send Us a Message</h4>
                    <p class="sub">Fill in the form below and our support team will get back to you.</p>

                    @if(session('contact_success'))
                        <div class="alert-ok mb-4">{{ session('contact_success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-4" style="border-radius:10px;font-size:14px;">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span style="color:#4C1D6B;">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                       placeholder="Your name" required maxlength="100">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address <span style="color:#4C1D6B;">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                       placeholder="you@example.com" required maxlength="100">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                       placeholder="+91 XXXXXXXXXX" maxlength="20">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}"
                                       placeholder="Order, refund, product query..." maxlength="120">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Your Message <span style="color:#4C1D6B;">*</span></label>
                                <textarea name="message" rows="5" class="form-control"
                                          placeholder="Tell us how we can help you..." required maxlength="2000">{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn-send">Submit Query</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-5">

                <div class="support-strip mb-4">
                    <h5 style="color:#0A0B2E;font-weight:700;margin-bottom:12px;">About POROSKART</h5>
                    <p style="color:#6b7280;font-size:14px;line-height:1.8;margin:0;">
                        POROSKART is a modern ecommerce platform powered by POROSINFOTECH PRIVATE LIMITED, focused on
                        delivering quality products, transparent pricing, and a smooth shopping experience across India.
                    </p>
                </div>

                <div class="support-strip">
                    <h5 style="color:#0A0B2E;font-weight:700;margin-bottom:12px;">Business Hours</h5>
                    <p style="color:#6b7280;font-size:14px;line-height:1.8;margin:0;">
                        Monday – Saturday: 10:00 AM – 7:00 PM<br>
                        Sunday: Closed<br>
                        Online orders are processed 24/7.
                    </p>
                </div>

            </div>

        </div>

    </div>
</section>
