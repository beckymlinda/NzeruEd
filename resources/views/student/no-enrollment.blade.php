@extends('layouts.app')

@section('title', 'Welcome to Yoga Fitness')

@section('content')
<div class="no-enrollment-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="welcome-card">
                    <!-- Animated Header -->
                    <div class="welcome-header">
                        <div class="welcome-icon">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                            </svg>
                        </div>
                        <h1 class="welcome-title">Welcome to Yoga Fitness</h1>
                        <p class="welcome-subtitle">Your yoga journey begins here</p>
                    </div>

                    <!-- Content Sections -->
                    <div class="welcome-content">
                        <!-- Current Status -->
                        <div class="status-section">
                            <div class="status-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="16" x2="12" y2="12"/>
                                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                                </svg>
                            </div>
                            <div class="status-content">
                                <h3>No Active Enrollment</h3>
                                <p>You're not currently enrolled in any yoga program. This could be because:</p>
                                <ul class="status-list">
                                    <li>You haven't enrolled in a program yet</li>
                                    <li>Your enrollment is still being processed</li>
                                    <li>Your previous enrollment has ended</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div class="steps-section">
                            <h3>What's Next?</h3>
                            <div class="steps-grid">
                                <div class="step-card">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <h4>Browse Programs</h4>
                                        <p>Explore our available yoga programs and find the perfect fit for your goals</p>
                                    </div>
                                </div>
                                <div class="step-card">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <h4>Get Enrolled</h4>
                                        <p>Contact our instructors or complete the enrollment process to get started</p>
                                    </div>
                                </div>
                                <div class="step-card">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <h4>Start Your Journey</h4>
                                        <p>Begin your yoga practice and track your progress in our system</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Benefits -->
                        <div class="benefits-section">
                            <h3>Why Choose Yoga Fitness?</h3>
                            <div class="benefits-grid">
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                    </div>
                                    <div class="benefit-text">
                                        <h4>Expert Instructors</h4>
                                        <p>Learn from certified yoga professionals</p>
                                    </div>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                    <div class="benefit-text">
                                        <h4>Progress Tracking</h4>
                                        <p>Monitor your yoga journey with detailed insights</p>
                                    </div>
                                </div>
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </div>
                                    <div class="benefit-text">
                                        <h4>Community</h4>
                                        <p>Join a supportive yoga community</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-section">
                        <div class="primary-action">
                            <a href="{{ route('student.programs.index') }}" class="btn-primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                    <polyline points="14,2 14,8 20,8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                                Browse Available Programs
                            </a>
                        </div>
                        <div class="secondary-actions">
                            <a href="#" class="btn-secondary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                </svg>
                                Contact Support
                            </a>
                            <a href="#" class="btn-secondary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Professional Styles -->
<style>
:root {
    --bg-primary: #0f0f0f;
    --bg-secondary: #1a1a1a;
    --bg-tertiary: #2a2a2a;
    --text-primary: #ffffff;
    --text-secondary: #b8b8b8;
    --text-muted: #888888;
    --accent-lavender: #9b59b6;
    --accent-lavender-light: #c39bd3;
    --accent-lavender-dark: #8e44ad;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --border-color: #3a3a3a;
}

.no-enrollment-wrapper {
    background: linear-gradient(135deg, var(--bg-primary) 0%, #1a1a2e 100%);
    min-height: 100vh;
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    padding: 2rem 0;
}

.welcome-card {
    background: var(--bg-secondary);
    border-radius: 24px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(155, 89, 182, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.welcome-header {
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}

.welcome-icon {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    border-radius: 20px;
    padding: 1.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 20px rgba(155, 89, 182, 0.3);
}

.welcome-icon svg {
    stroke: white;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #ffffff 0%, rgba(255,255,255,0.8) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-bottom: 0;
}

.welcome-content {
    margin-bottom: 3rem;
}

.status-section {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    padding: 2rem;
    background: var(--bg-tertiary);
    border-radius: 16px;
    margin-bottom: 2rem;
    border-left: 4px solid var(--warning-color);
}

.status-icon {
    background: rgba(245, 158, 11, 0.2);
    color: var(--warning-color);
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.status-content h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.status-content p {
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.status-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.status-list li {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    padding-left: 1.5rem;
    position: relative;
}

.status-list li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--accent-lavender);
    font-weight: 600;
}

.steps-section h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 2rem;
    text-align: center;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.step-card {
    background: var(--bg-tertiary);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
}

.step-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    border-color: var(--accent-lavender);
}

.step-number {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    margin: 0 auto 1.5rem;
}

.step-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
}

.step-content p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}

.benefits-section h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 2rem;
    text-align: center;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.benefit-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-tertiary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.benefit-item:hover {
    transform: translateY(-2px);
    border-color: var(--accent-lavender);
}

.benefit-icon {
    background: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
    border-radius: 10px;
    padding: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.benefit-text h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.benefit-text p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    line-height: 1.4;
}

.action-section {
    text-align: center;
}

.primary-action {
    margin-bottom: 1.5rem;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    color: white;
    padding: 1rem 2.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(155, 89, 182, 0.3);
}

.secondary-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--accent-lavender);
    color: white;
    border-color: var(--accent-lavender);
}

/* Responsive Design */
@media (max-width: 768px) {
    .no-enrollment-wrapper {
        padding: 1rem 0;
    }
    
    .welcome-card {
        padding: 2rem 1.5rem;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .status-section {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
    }
    
    .steps-grid {
        grid-template-columns: 1fr;
    }
    
    .benefits-grid {
        grid-template-columns: 1fr;
    }
    
    .secondary-actions {
        flex-direction: column;
    }
    
    .btn-primary {
        padding: 0.875rem 2rem;
        font-size: 1rem;
    }
    
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .welcome-card {
        padding: 1.5rem 1rem;
    }
    
    .welcome-title {
        font-size: 1.75rem;
    }
    
    .step-card {
        padding: 1.5rem;
    }
    
    .benefit-item {
        padding: 1rem;
    }
}
</style>
@endsection
