<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions — NYU</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admissions.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <!-- Hero -->
    <section class="page-hero">
        <div class="hero-inner">
            <div class="hero-copy">
                <h1>Admissions</h1>
                <p>NYU welcomes students who demonstrate academic excellence, creativity, and leadership. Below you'll find detailed guidance for undergraduate, graduate and international applicants, timelines, estimated costs, and next steps to apply.</p>
                <a class="cta" href="#how-to-apply">How to Apply</a>
            </div>
            <div class="hero-media">
                <img src="img/admitions.jpg" alt="Admissions" style="width:420px;max-width:40vw;border-radius:10px;box-shadow:0 18px 40px rgba(20,30,80,0.12)">
            </div>
        </div>
    </section>

    <main class="container">
        <!-- Overview -->
        <section id="overview" style="margin-bottom:2rem;">
            <h2 style="color:#0f1724;margin-bottom:0.5rem;">Overview</h2>
            <p style="color:#444;line-height:1.7;">NYU offers a wide range of undergraduate, graduate and professional programs. Admissions criteria vary by school and program; most decisions are based on a holistic review of academic record, recommendations, personal statement, and demonstrated interests. Use the sections below to jump directly to the information you need.</p>
        </section>

        <!-- Application Categories -->
        <section id="categories" style="margin-bottom:2rem;">
            <div class="admissions-grid">
                <div class="ad-card">
                    <h3>Undergraduate Admissions</h3>
                    <p>First-year and transfer applicants should review requirements for high school curriculum, recommended coursework, and application components. Students may apply via the Common App. Key materials typically include transcripts, a personal essay, recommendations, and (optional) standardized test scores.</p>
                    <p><strong>Typical timeline:</strong> Early Action/Decision deadlines are usually in November; Regular Decision deadlines in January.</p>
                </div>
                <div class="ad-card">
                    <h3>Graduate Admissions</h3>
                    <p>Graduate admissions are program-specific. Requirements commonly include academic transcripts, statement of purpose, CV, letters of recommendation, and (for many programs) GRE/GMAT. Funding and assistantships vary by department — check each program's pages for details.</p>
                    <p><strong>Tip:</strong> Contact the program coordinator for application-specific questions and funding opportunities.</p>
                </div>
                <div class="ad-card">
                    <h3>International Applicants</h3>
                    <p>International applicants should pay attention to credential evaluation, visa planning, and English language proficiency requirements. Official transcripts must often be translated and evaluated; accepted tests include TOEFL and IELTS (requirements vary by program).</p>
                    <p><strong>Note:</strong> Allow extra time for document collection and visa processing.</p>
                </div>
            </div>
        </section>

        <!-- How to Apply / Checklist -->
        <section id="how-to-apply" style="margin-bottom:2rem;">
            <h2 style="color:#0f1724;margin-bottom:0.5rem;">How to Apply — Step by Step</h2>
            <div class="timeline">
                <div class="step">
                    <strong>1. Choose a Program</strong>
                    <div style="color:#555;font-size:0.95rem;margin-top:0.4rem;">Use the program pages to confirm requirements and deadlines.</div>
                </div>
                <div class="step">
                    <strong>2. Prepare Documents</strong>
                    <div style="color:#555;font-size:0.95rem;margin-top:0.4rem;">Transcripts, test scores, essays, CV, recommendation letters.</div>
                </div>
                <div class="step">
                    <strong>3. Submit Application</strong>
                    <div style="color:#555;font-size:0.95rem;margin-top:0.4rem;">Complete the online application and pay the fee (or request a fee waiver).</div>
                </div>
                <div class="step">
                    <strong>4. Await Decision</strong>
                    <div style="color:#555;font-size:0.95rem;margin-top:0.4rem;">Decisions are posted to your applicant portal; some programs may interview candidates.</div>
                </div>
            </div>

            <div class="checklist" style="margin-top:1rem;">
                <h3 style="margin-top:0;">Application Checklist</h3>
                <ul style="color:#444;line-height:1.6;margin:0.5rem 0 0 1.1rem;">
                    <li>Official transcripts (high school and/or previous postsecondary)</li>
                    <li>Personal statement / statement of purpose</li>
                    <li>Letters of recommendation (usually 2–3)</li>
                    <li>Standardized test scores (if required or submitted)</li>
                    <li>CV / resume (for graduate applicants)</li>
                    <li>Portfolio (for select programs)</li>
                    <li>Proof of English proficiency (international applicants)</li>
                </ul>
            </div>
        </section>

        <!-- Deadlines & Costs -->
        <section id="deadlines-costs" style="margin-bottom:2rem;">
            <h2 style="color:#0f1724;margin-bottom:0.5rem;">Important Dates & Estimated Costs</h2>
            <div class="admissions-grid">
                <div class="ad-card">
                    <h3>Important Dates (Typical)</h3>
                    <table class="info-table">
                        <tr><th>Event</th><th>Typical Deadline</th></tr>
                        <tr><td>Early Action / Early Decision</td><td>November</td></tr>
                        <tr><td>Regular Decision</td><td>January</td></tr>
                        <tr><td>Graduate Program Deadlines</td><td>Varies by program — often Dec–Feb</td></tr>
                        <tr><td>International Document Deadlines</td><td>Allow extra 4–8 weeks</td></tr>
                    </table>
                </div>
                <div class="ad-card">
                    <h3>Tuition & Financial Aid</h3>
                    <p>Costs vary by program and living choices. Below are approximate annual figures for planning purposes only.</p>
                    <table class="info-table">
                        <tr><th>Item</th><th>Estimate (2025)</th></tr>
                        <tr><td>Undergraduate tuition</td><td>$55,000–$60,000</td></tr>
                        <tr><td>Graduate tuition (varies)</td><td>$30,000–$60,000</td></tr>
                        <tr><td>Room & board (NYC)</td><td>$18,000–$24,000</td></tr>
                    </table>
                    <p style="margin-top:0.6rem;color:#444;">Financial aid, scholarships, and assistantships are available — apply early and check program pages for funding opportunities.</p>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" style="margin-bottom:2rem;">
            <h2 style="color:#0f1724;margin-bottom:0.5rem;">Frequently Asked Questions</h2>
            <div class="faq-item">
                <h4>When will I hear back about my application?</h4>
                <p style="color:#444;line-height:1.6;">Notification timelines depend on the program and application type. Early applicants typically receive decisions sooner (December), regular applicants in March–April. Graduate program timelines vary — check program pages for specifics.</p>
            </div>
            <div class="faq-item">
                <h4>Can I defer enrollment after acceptance?</h4>
                <p style="color:#444;line-height:1.6;">Many programs allow deferrals on a case-by-case basis. Contact the admissions office for the school that accepted you to discuss deferral policies.</p>
            </div>
            <div class="faq-item">
                <h4>Are test scores required?</h4>
                <p style="color:#444;line-height:1.6;">Standardized test policies differ across programs and change over time. Some undergraduate programs are test-optional; many graduate programs may require GRE/GMAT. Always check the program's admissions page for the latest policy.</p>
            </div>
        </section>

        <!-- Contact & Next Steps -->
        <section id="contact" style="margin-bottom:3rem;">
            <h2 style="color:#0f1724;margin-bottom:0.5rem;">Contact & Next Steps</h2>
            <p style="color:#444;line-height:1.6;">For program-specific questions, contact the admissions office of the school you are applying to. General admissions questions can be sent to <a href="mailto:admissions@nyu.edu">admissions@nyu.edu</a> or use the online contact forms on program pages.</p>
            <p style="color:#444;line-height:1.6;">Plan a campus visit or attend a virtual information session — these are great ways to learn about fit, program strengths, and student life.</p>
            <a class="cta" href="../auth/register.php" style="display:inline-block;margin-top:0.6rem;">Start Your Application</a>
        </section>
    </main>

    <!-- Footer -->
     <footer>
    <?php include '../components/footer.php'; ?>
    </footer>
</body>
</html>
