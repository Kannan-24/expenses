<x-guest-layout>
    <x-slot name="title">Privacy Policy | DD Expenses - A Personal Finance Tracking App</x-slot>


    <div class="mt-24">
        <div class="w-full mx-auto max-w-4xl sm:px-6 lg:px-8 p-6 m-4">
            <h3 class="text-3xl text-center font-bold mb-6 text-gray-800">Privacy Policy</h3>

            <p class="mb-4 text-gray-700">
                This Privacy Policy explains how Duo Dev Technologies ("we", "our", or "us") collects, uses, and
                protects your personal information when you use our services through <a href="https://duodev.in"
                    class="text-blue-600 underline">https://duodev.in</a>.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">1. Information We Collect</h4>
            <p class="mb-2 text-gray-700">
                When you use our services, we may collect the following personal information:
            </p>
            <ul class="list-disc ml-6 text-gray-700 mb-4">
                <li>Name (only when using Google Sign-In)</li>
                <li>Email address (only when using Google Sign-In)</li>
                <li>Usage data such as access times and pages visited (for analytics and improvements)</li>
            </ul>

            <h4 class="text-2xl font-semibold mt-6 mb-2">2. Use of Google Sign-In</h4>
            <p class="mb-4 text-gray-700">
                We use Google Sign-In as an authentication method for account creation and login. When you log in with
                Google, we access only your:
            </p>
            <ul class="list-disc ml-6 text-gray-700 mb-4">
                <li>Full Name</li>
                <li>Email Address</li>
            </ul>
            <p class="mb-4 text-gray-700">
                This information is stored securely and is only used to personalize your experience and manage your
                account within our web application. We do not access or store your Google password or other sensitive
                data.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">3. How We Use Your Information</h4>
            <p class="mb-4 text-gray-700">
                We use the collected information to:
            </p>
            <ul class="list-disc ml-6 text-gray-700 mb-4">
                <li>Provide, operate, and maintain our services</li>
                <li>Communicate with you regarding your account or support requests</li>
                <li>Improve and personalize your user experience</li>
                <li>Send notifications related to your activity within the app</li>
            </ul>

            <h4 class="text-2xl font-semibold mt-6 mb-2">4. Data Sharing and Disclosure</h4>
            <p class="mb-4 text-gray-700">
                We do not sell, rent, or share your personal information with third parties except:
            </p>
            <ul class="list-disc ml-6 text-gray-700 mb-4">
                <li>To comply with legal obligations or law enforcement requests</li>
                <li>To trusted service providers who help us operate the application (e.g., hosting, email delivery)
                </li>
            </ul>

            <h4 class="text-2xl font-semibold mt-6 mb-2">5. Data Retention</h4>
            <p class="mb-4 text-gray-700">
                We retain your data only for as long as necessary to fulfill the purposes outlined in this policy, or as
                required by law.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">6. Your Rights</h4>
            <p class="mb-4 text-gray-700">
                You have the right to:
            </p>
            <ul class="list-disc ml-6 text-gray-700 mb-4">
                <li>Access the personal data we hold about you</li>
                <li>Request correction or deletion of your data</li>
                <li>Withdraw consent for data processing (e.g., stop receiving emails)</li>
            </ul>

            <h4 class="text-2xl font-semibold mt-6 mb-2">7. Cookies and Tracking</h4>
            <p class="mb-4 text-gray-700">
                We may use cookies or similar tracking technologies to improve your browsing experience. You can disable
                cookies via your browser settings, though some functionality may be affected.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">8. Data Security</h4>
            <p class="mb-4 text-gray-700">
                We implement appropriate technical and organizational measures to protect your data against unauthorized
                access, alteration, disclosure, or destruction.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">9. Third-Party Links</h4>
            <p class="mb-4 text-gray-700">
                Our site may contain links to third-party websites or services. We are not responsible for the content
                or privacy practices of those third parties.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">10. Changes to This Privacy Policy</h4>
            <p class="mb-4 text-gray-700">
                We may update this Privacy Policy from time to time. We encourage you to review this page periodically
                for any changes. Continued use of the service after changes implies acceptance of the revised policy.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">11. Contact Us</h4>
            <p class="mb-4 text-gray-700">
                If you have any questions about this Privacy Policy, please contact us at <a
                    href="mailto:support@duodev.in" class="text-blue-600 underline">support@duodev.in</a>.
            </p>

            <p class="mt-6 text-sm text-gray-500">
                Last updated: {{ \Carbon\Carbon::parse('2025-06-28')->format('F j, Y') }}
            </p>
        </div>
    </div>
</x-guest-layout>
