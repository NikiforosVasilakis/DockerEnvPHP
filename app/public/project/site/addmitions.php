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
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Page-level styles matching Index/About/Research */
        body { background: #fbfdff; }
        .header { background-color: transparent; }
        .page-hero { padding:4rem 2rem; background: linear-gradient(180deg,#f4f7ff,#fff); }
        .hero-inner { max-width:1200px; margin:0 auto; display:flex; gap:2rem; align-items:center; }
        .hero-copy { flex:1; }
        .hero-copy h1 { font-size:2.4rem; color:#0f1724; margin:0 0 0.5rem 0; }
        .hero-copy p { margin:0 0 1rem 0; color:#444; line-height:1.7; }
        .cta { display:inline-block; padding:0.7rem 1rem; background:#667eea; color:#fff; border-radius:8px; text-decoration:none; font-weight:600; }

        .container { max-width:1100px; margin:0 auto; padding:2rem; }
        .admissions-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:1.25rem; }
        .ad-card { background:#fff; border-radius:10px; padding:1.25rem; box-shadow:0 10px 30px rgba(12,20,50,0.06); }
        .ad-card h3 { margin:0 0 0.5rem 0; color:#0f1724; }
        .ad-card p { margin:0; color:#555; line-height:1.6; }

        .timeline { display:flex; gap:1rem; flex-wrap:wrap; margin:1rem 0 2rem 0; }
        .timeline .step { background:#fff; border-radius:8px; padding:0.9rem 1rem; box-shadow:0 6px 18px rgba(12,20,50,0.06); flex:1 1 180px; }
        .checklist { background:#fff; border-radius:10px; padding:1rem; box-shadow:0 10px 30px rgba(12,20,50,0.06); }
        .faq-item { margin-bottom:1rem; }
        .faq-item h4 { margin:0 0 0.4rem 0; }

        table.info-table { width:100%; border-collapse:collapse; margin-top:0.75rem; }
        table.info-table td, table.info-table th { padding:0.6rem; border:1px solid #eef2ff; }

        @media (max-width:900px){ .hero-inner{flex-direction:column; align-items:flex-start;} }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header class="header">
        <div class="header-container">
            <div class="logo-section">
                <a href="index.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: white;">
                    <img src="img/nyu-logo.png" alt="NYU Logo" class="logo-icon">
                    <span class="logo-text">NEW YORK UNIVERSITY</span>
                </a>
            </div>
            <nav class="main-nav">
                <div class="nav-groups-wrapper">
                    <div class="nav-group nav-group-1">
                        <a href="about.html" class="nav-link">About</a>
                        <a href="research.php" class="nav-link">Research</a>
                        <a href="addmitions.html" class="nav-link">Admissions</a>
                        <a href="#news" class="nav-link">News</a>
                        <a href="academics.html" class="nav-link">Academics</a>
                        <a href="campus_life.html" class="nav-link">Campus Life</a>
                        <div class="search-container">
                            <input type="text" placeholder="Search..." class="search-input">
                            <button class="search-btn" aria-label="Search"></button>
                        </div>
                    </div>
                    <!-- e-class button placed for quick access -->
                    <a href="php-files/login.php" class="login-btn nav-login-btn" target="_blank">e-class</a>
                </div>
            </nav>
    <?php include 'componments/footer.php';?>
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
            <a class="cta" href="php-files/register.php" style="display:inline-block;margin-top:0.6rem;">Start Your Application</a>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'componments/footer.php';?>

</body>
</html>
