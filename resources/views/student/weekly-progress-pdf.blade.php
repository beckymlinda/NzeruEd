<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weekly Progress Report - Week {{ $weeklyProgress->week_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #9b59b6;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #9b59b6;
            font-size: 24pt;
            margin-bottom: 5px;
        }
        
        .header h2 {
            color: #666;
            font-size: 14pt;
            margin-bottom: 0;
        }
        
        .overall-score {
            background: #9b59b6;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        .overall-score .value {
            font-size: 28pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .overall-score .label {
            font-size: 12pt;
            opacity: 0.9;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #9b59b6;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .info-item {
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 10pt;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .info-value {
            color: #333;
            font-size: 12pt;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16pt;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .scores-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .score-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #9b59b6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .score-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            font-size: 12pt;
        }
        
        .score-value {
            font-size: 20pt;
            font-weight: bold;
            color: #9b59b6;
            margin-bottom: 3px;
        }
        
        .score-percentage {
            font-size: 10pt;
            color: #666;
        }
        
        .feedback-section {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #10b981;
            margin-bottom: 20px;
        }
        
        .feedback-content {
            color: #333;
            line-height: 1.5;
            font-size: 11pt;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10pt;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>WEEKLY PROGRESS REPORT</h1>
        <h2>Week {{ $weeklyProgress->week_number }} • {{ \Carbon\Carbon::parse($weeklyProgress->created_at)->format('F j, Y') }}</h2>
    </div>
    
    @php
        $scores = [
            'Flexibility' => $weeklyProgress->flexibility_score ?? 0,
            'Strength' => $weeklyProgress->strength_score ?? 0,
            'Balance' => $weeklyProgress->balance_score ?? 0,
            'Mindset' => $weeklyProgress->mindset_score ?? 0
        ];
        $avgScore = array_sum($scores) / 4;
        $status = $avgScore >= 8 ? 'EXCELLENT' : ($avgScore >= 6 ? 'GOOD' : ($avgScore >= 4 ? 'PROGRESSING' : 'NEEDS WORK'));
    @endphp
    
    <!-- Overall Score -->
    <div class="overall-score">
        <div class="value">{{ number_format($avgScore, 1) }}/10</div>
        <div class="label">{{ $status }} PERFORMANCE</div>
    </div>
    
    <!-- Student Information -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Student Name</div>
                <div class="info-value">{{ auth()->user()->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Program</div>
                <div class="info-value">{{ $weeklyProgress->enrollment->program->title ?? 'Yoga Program' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Week Number</div>
                <div class="info-value">Week {{ $weeklyProgress->week_number }} of 12</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date Recorded</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($weeklyProgress->created_at)->format('F j, Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Progress Status</div>
                <div class="info-value">{{ round(($weeklyProgress->week_number / 12) * 100) }}% Complete</div>
            </div>
            <div class="info-item">
                <div class="info-label">Report ID</div>
                <div class="info-value">WK-{{ $weeklyProgress->week_number }}-{{ $weeklyProgress->id }}-{{ date('Y') }}</div>
            </div>
        </div>
    </div>
    
    <!-- Performance Scores -->
    <div class="section">
        <h2 class="section-title">Performance Analysis</h2>
        <div class="scores-grid">
            @foreach($scores as $label => $score)
                <div class="score-card">
                    <div class="score-label">{{ $label }}</div>
                    <div class="score-value">{{ $score }}/10</div>
                    <div class="score-percentage">{{ $score * 10 }}%</div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Instructor Feedback -->
    @if($weeklyProgress->instructor_notes)
        <div class="section">
            <h2 class="section-title">Instructor Feedback</h2>
            <div class="feedback-section">
                <div class="feedback-content">
                    {!! nl2br(e($weeklyProgress->instructor_notes)) !!}
                </div>
            </div>
        </div>
    @endif
    
    <!-- Overall Assessment -->
    @if($weeklyProgress->overall_feedback)
        <div class="section">
            <h2 class="section-title">Overall Assessment</h2>
            <div class="feedback-section">
                <div class="feedback-content">
                    {!! nl2br(e($weeklyProgress->overall_feedback)) !!}
                </div>
            </div>
        </div>
    @endif
    
    <!-- Footer -->
    <div class="footer">
        <div><strong>NZERUED YOGA MANAGEMENT SYSTEM</strong></div>
        <div>Generated on {{ \Carbon\Carbon::now()->format('F j, Y g:i A') }}</div>
        <div>© {{ date('Y') }} NzeruEd Yoga Management. All rights reserved.</div>
    </div>
</body>
</html>
