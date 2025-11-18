@extends('layouts.app')

@section('title', 'Terms and Conditions')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header text-center bg-light-green py-3">
                        <h1 class="mb-0 fw-bold text-dark fs-4">Terms and Conditions</h1>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <p class="text-muted">Last updated: {{ now()->format('F d, Y') }}</p>

                        <p>Welcome to Halmazing! These Terms and Conditions (“Terms”) govern your use of our website
                            located at <a href="https://halmazing.com" class="text-decoration-none">halmazing.com</a>
                            and our services (the “Service”). By accessing or using our Service, you agree to be bound
                            by these Terms. If you disagree with any part, you may not access the Service.</p>

                        <h2 class="mt-4 fs-5 fw-bold">1. Accounts</h2>
                        <p>When you create an account with us, you must provide accurate, complete, and current
                            information. You are responsible for safeguarding your account credentials and must notify
                            us immediately of any unauthorized use.</p>

                        <h2 class="mt-4 fs-5 fw-bold">2. Use of the Service</h2>
                        <p>You agree to use the Service only for lawful purposes. You must not:</p>
                        <ul>
                            <li>Violate any applicable law or regulation.</li>
                            <li>Exploit or harm minors.</li>
                            <li>Transmit viruses or harmful code.</li>
                            <li>Interfere with other users’ access to the Service.</li>
                        </ul>

                        <h2 class="mt-4 fs-5 fw-bold">3. Intellectual Property</h2>
                        <p>The Service and its content are the exclusive property of Halmazing. You may not copy,
                            modify, distribute, or sell any part of the Service without written permission.</p>

                        <h2 class="mt-4 fs-5 fw-bold">4. Purchases</h2>
                        <p>When you purchase products or services, you agree to provide accurate payment information and
                            authorize us to charge applicable fees. All sales are final unless otherwise stated.</p>

                        <h2 class="mt-4 fs-5 fw-bold">5. Termination</h2>
                        <p>We may terminate or suspend your account and access to the Service at any time, without prior
                            notice, for any reason including breach of these Terms. Upon termination, your right to use
                            the Service ceases immediately.</p>

                        <h2 class="mt-4 fs-5 fw-bold">6. Limitation of Liability</h2>
                        <p>To the fullest extent permitted by law, Halmazing is not liable for indirect, incidental,
                            special, consequential, or punitive damages, or any loss of profits, data, or goodwill
                            resulting from your use of the Service.</p>

                        <h2 class="mt-4 fs-5 fw-bold">7. Indemnification</h2>
                        <p>You agree to defend, indemnify, and hold harmless Halmazing, its affiliates, and service
                            providers from any claims, liabilities, damages, or expenses arising from your use of the
                            Service or violation of these Terms.</p>

                        <h2 class="mt-4 fs-5 fw-bold">8. Governing Law</h2>
                        <p>These Terms are governed by the laws of [Your Country/State]. Any dispute arising under
                            these Terms shall be subject to the exclusive jurisdiction of the courts in [Your City,
                            Country/State].</p>

                        <h2 class="mt-4 fs-5 fw-bold">9. Changes to Terms</h2>
                        <p>We may update these Terms at any time. We will notify you by posting the new Terms on this
                            page and updating the “Last updated” date. Your continued use of the Service constitutes
                            acceptance of the updated Terms.</p>

                        <h2 class="mt-4 fs-5 fw-bold">10. Contact Us</h2>
                        <p>If you have any questions about these Terms, please contact us by email at: 
                            <a href="mailto:support@halmazing.com" target="_blank" rel="noopener noreferrer">support@halmazing.com</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
