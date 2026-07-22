<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        $apiKey = env('GEMINI_API_KEY', 'AQ.Ab8RN6KSiGdrTQyheqFz4aJTBAUMVlA_rM_Pz8qxJGl5mke88g');

        // Dynamic system context with safe fallback
        $phone = '01334958490';
        $email = 'support@hosenacademy.com';
        try {
            if (function_exists('get_settings')) {
                $dbPhone = get_settings('phone');
                if ($dbPhone) $phone = $dbPhone;

                $dbEmail = get_settings('system_email');
                if ($dbEmail) $email = $dbEmail;
            }
        } catch (\Throwable $e) {
            // Use defaults if DB is temporarily unreachable
        }

        $systemInstruction = "You are the Official AI Assistant of Hosen Academy (হোসেন একাডেমি এআই অ্যাসিস্ট্যান্ট). You provide accurate, helpful, polite, and professional information in Bengali (or English if prompted in English) strictly about Hosen Academy's products, services, and courses.

HOSEN ACADEMY KNOWLEDGE BASE:
- Contact Phone / WhatsApp: {$phone}
- Email: {$email}

OFFERED PRODUCTS & SERVICES:
1. Website Development: Custom website design, Laravel, WordPress, e-commerce platforms, responsive UI/UX design.
2. Mobile App Development: Android & iOS app development using Flutter / React Native, high performance native mobile apps.
3. Custom Software Development: Custom ERP, CRM, LMS platforms, POS systems, inventory management software, API integration.
4. Ready-made Templates & Scripts: Ready web scripts, UI kits, LMS starter templates, business management templates.
5. Online Courses: Programming (PHP, Laravel, Python, JavaScript), Web Development, Graphic Design, Digital Marketing, Spoken English, Freelancing, Bank & BCS Job Exam Preparation. Video lessons + PDF materials + dedicated instructor support.
6. eBooks & Digital Products: Professional PDFs, programming books, skill guides, career cheat sheets.
7. Technical Consultation & Support: Project consultation, system maintenance, server setup.

STRICT MANDATORY RULES:
1. Do NOT include any emojis, emoticons, or smiley icons under any circumstances. Keep all responses clean, professional, and readable using bullet points and plain text only.
2. EVERY response MUST end with a contextually relevant Call-To-Action (CTA) recommendation or next step based on the topic discussed!
- If the user asks about Courses or eBooks:
  End with: 'If you would like to learn more, you can visit the Courses/eBooks section of our website for detailed information. (আপনার পছন্দের কোর্স বা eBook সম্পর্কে বিস্তারিত জানতে আমাদের ওয়েবসাইটের Courses / eBooks সেকশন ভিজিট করতে পারেন।)'
- If the user asks about Software, Web, or Mobile App Development:
  End with: 'If you would like more details, you can visit our Software Services section or contact our team for a free consultation. (আপনার প্রজেক্টের প্রয়োজনীয়তা আলোচনা করতে বা ফ্রি কন্সাল্টেশন নিতে আমাদের টিমের সাথে সরাসরি যোগাযোগ করুন, WhatsApp: {$phone})'
- If the user asks about General / Support topics:
  End with: 'আরও বিস্তারিত তথ্যের জন্য আমাদের ওয়েবসাইটে যুক্ত থাকুন অথবা আমাদের সাথে সরাসরি যোগাযোগ করুন (WhatsApp: {$phone})।'";

        // Build Gemini API payload
        $contents = [];

        // Add System context as first message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => "System Instructions:\n" . $systemInstruction]]
        ];
        $contents[] = [
            'role' => 'model',
            'parts' => [['text' => "বুঝেছি! আমি হোসেন একাডেমি এআই অ্যাসিস্ট্যান্ট। হোসেন একাডেমির কোর্স, ইবুক এবং সফটওয়্যার ডেভেলপমেন্ট সার্ভিস সম্পর্কিত সকল প্রশ্নের সঠিক উত্তর দেব এবং প্রতিটি উত্তরের শেষে যথাযথ Call-To-Action প্রদান করব।"]]
        ];

        // Add user chat history
        foreach ($history as $chat) {
            if (isset($chat['role']) && isset($chat['content'])) {
                $role = ($chat['role'] === 'user') ? 'user' : 'model';
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $chat['content']]]
                ];
            }
        }

        // Add current user message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        $models = ['gemini-flash-latest', 'gemini-2.0-flash-lite', 'gemini-2.0-flash'];
        $reply = null;

        foreach ($models as $model) {
            try {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->timeout(12)->post($url, [
                    'contents' => $contents,
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $reply = isset($json['candidates'][0]['content']['parts'][0]['text']) ? $json['candidates'][0]['content']['parts'][0]['text'] : null;
                    if ($reply) {
                        break;
                    }
                }
            } catch (\Exception $e) {
                // Try next model if exception occurs
            }
        }

        if (!$reply) {
            $reply = $this->getLocalFallbackResponse($userMessage, $phone);
        }

        return response()->json([
            'status' => 'success',
            'reply' => $reply,
        ]);
    }

    private function getLocalFallbackResponse($userMessage, $phone)
    {
        $msg = mb_strtolower($userMessage, 'UTF-8');

        if (str_contains($msg, 'course') || str_contains($msg, 'কোর্স') || str_contains($msg, 'ebook') || str_contains($msg, 'বই')) {
            return "হোসেন একাডেমিতে আপনি পাচ্ছেন প্রোগ্রামিং, ওয়েব ডেভেলপমেন্ট, গ্রাফিক ডিজাইন, ডিজিটাল মার্কেটিং, ব্যাংক ও চাকরি প্রস্তুতির মানসম্মত প্রিমিয়াম কোর্স এবং উচ্চমানের eBooks।\n\nIf you would like to learn more, you can visit the Courses/eBooks section of our website for detailed information. (আপনার পছন্দের কোর্স বা eBook সম্পর্কে বিস্তারিত জানতে আমাদের ওয়েবসাইটের Courses / eBooks সেকশন ভিজিট করতে পারেন।)";
        }

        if (str_contains($msg, 'web') || str_contains($msg, 'app') || str_contains($msg, 'software') || str_contains($msg, 'ওয়েবসাইট') || str_contains($msg, 'অ্যাপ') || str_contains($msg, 'সফটওয়্যার')) {
            return "হোসেন একাডেমি প্রফেশনাল ওয়েবসাইট ডেভেলপমেন্ট, মোবাইল অ্যাপ ডেভেলপমেন্ট (Android/iOS), কাস্টম ERP/LMS এবং রেডি-মেড সফটওয়্যার টেমপ্লেট সেবা প্রদান করে।\n\nIf you would like more details, you can visit our Software Services section or contact our team for a free consultation. (আপনার প্রজেক্টের প্রয়োজনীয়তা আলোচনা করতে বা ফ্রি কন্সাল্টেশন নিতে আমাদের টিমের সাথে সরাসরি যোগাযোগ করুন, WhatsApp: {$phone})";
        }

        return "জি! হোসেন একাডেমি হলো একটি প্রিমিয়াম অনলাইন লার্নিং প্ল্যাটফর্ম ও আইটি সফটওয়্যার সলিউশন এজেন্সি। এখানে আপনি উন্নত কোর্স, ইবুক এবং কাস্টম সফটওয়্যার ডেভেলপমেন্ট সার্ভিস পাবেন।\n\nআরও বিস্তারিত তথ্যের জন্য আমাদের ওয়েবসাইটে যুক্ত থাকুন অথবা আমাদের সাথে সরাসরি যোগাযোগ করুন (WhatsApp: {$phone})।";
    }
}
