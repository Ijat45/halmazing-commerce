@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header text-center bg-light-green py-3">
                        <h1 class="mb-0 fw-bold text-dark fs-4">Privacy Policy</h1>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <p class="text-muted">Last updated: {{ now()->format('F d, Y') }}</p>

                        <p>This Privacy Policy describes how Halmazing (“we”, “our”, or “us”) collects, uses, and shares
                            information about you when you use our website <a href="https://halmazing.com" class="text-decoration-none">halmazing.com</a>
                            and any other services we provide (collectively, the “Service”). By using our Service, you
                            consent to the practices described in this Privacy Policy.</p>

                        <h2 class="mt-4 fs-5 fw-bold">1. Information We Collect</h2>
                        <h3 class="mt-3 fs-6 fw-semibold">1.1 Personal Information</h3>
                        <p>When you use our Service, we may collect personal information that can identify you, such as:</p>
                        <ul>
                            <li>Full name</li>
                            <li>Email address</li>
                            <li>Phone number</li>
                            <li>Billing/shipping address</li>
                            <li>Account credentials</li>
                        </ul>

                        <h3 class="mt-3 fs-6 fw-semibold">1.2 Usage Data</h3>
                        <p>We automatically collect information about how you interact with our Service, including:</p>
                        <ul>
                            <li>IP address, device type, and browser information</li>
                            <li>Pages you visit and time spent on pages</li>
                            <li>Clickstream data and other analytics</li>
                        </ul>

                        <h3 class="mt-3 fs-6 fw-semibold">1.3 Cookies and Tracking Technologies</h3>
                        <p>We use cookies and similar technologies to enhance your experience, understand user behavior,
                            and deliver personalized content. You may manage your cookie preferences through your browser
                            settings.</p>

                        <h2 class="mt-4 fs-5 fw-bold">2. How We Use Your Information</h2>
                        <p>We may use your information for purposes including:</p>
                        <ul>
                            <li>To provide, maintain, and improve our Service</li>
                            <li>To personalize your experience and deliver relevant content</li>
                            <li>To process transactions and send related information</li>
                            <li>To communicate with you, including promotional and marketing messages (you can opt out at any time)</li>
                            <li>To detect, prevent, and address technical issues or fraudulent activity</li>
                            <li>To comply with legal obligations</li>
                        </ul>

                        <h2 class="mt-4 fs-5 fw-bold">3. Sharing Your Information</h2>
                        <p>We may share your information in the following cases:</p>
                        <ul>
                            <li>With service providers who perform services on our behalf</li>
                            <li>To comply with legal obligations, protect our rights, or enforce our Terms</li>
                            <li>In connection with a merger, acquisition, or sale of assets</li>
                            <li>With your consent or at your direction</li>
                        </ul>

                        <h2 class="mt-4 fs-5 fw-bold">4. Data Retention</h2>
                        <p>We retain personal information only for as long as necessary to fulfill the purposes outlined in
                            this Privacy Policy, comply with legal obligations, resolve disputes, and enforce agreements.</p>

                        <h2 class="mt-4 fs-5 fw-bold">5. Your Rights</h2>
                        <p>Depending on your location, you may have rights regarding your personal information, including:</p>
                        <ul>
                            <li>Accessing the information we hold about you</li>
                            <li>Correcting inaccurate or incomplete information</li>
                            <li>Requesting deletion of your personal data</li>
                            <li>Objecting to or restricting processing of your data</li>
                            <li>Withdrawing consent at any time (without affecting prior processing)</li>
                        </ul>
                        <p>To exercise these rights, please contact us via email at <strong>privacy@halmazing.com</strong>.</p>

                        <h2 class="mt-4 fs-5 fw-bold">6. Security of Your Data</h2>
                        <p>We implement reasonable administrative, technical, and physical measures to protect your
                            information. However, no method of transmission or storage is completely secure, and we
                            cannot guarantee absolute security.</p>

                        <h2 class="mt-4 fs-5 fw-bold">7. Children’s Privacy</h2>
                        <p>Our Service is not directed to children under 13. We do not knowingly collect personal
                            information from children under 13. If we learn that we have collected such data, we take
                            steps to delete it.</p>

                        <h2 class="mt-4 fs-5 fw-bold">8. Third-Party Links</h2>
                        <p>Our Service may contain links to third-party websites. We are not responsible for the privacy
                            practices of these sites. We encourage you to review the privacy policies of any sites you
                            visit.</p>

                        <h2 class="mt-4 fs-5 fw-bold">9. International Transfers</h2>
                        <p>We may transfer your information to countries other than your residence. By using the Service,
                            you consent to such transfers in accordance with applicable data protection laws.</p>

                        <h2 class="mt-4 fs-5 fw-bold">10. Changes to this Privacy Policy</h2>
                        <p>We may update this Privacy Policy from time to time. We will notify you of changes by posting
                            the updated policy on this page and updating the “Last updated” date. Your continued use of
                            the Service constitutes acceptance of the updated policy.</p>

                        <h2 class="mt-4 fs-5 fw-bold">11. Contact Us</h2>
                        <p>If you have any questions about this Privacy Policy, please contact us by email at: 
                            <a href="mailto:privacy@halmazing.com" target="_blank" rel="noopener noreferrer">privacy@halmazing.com</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
