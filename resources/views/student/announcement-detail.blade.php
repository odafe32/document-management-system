@extends('layout.student')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: #ffffff;
        color: #2d3748;
        line-height: 1.6;
    }

    .announcement-detail-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .announcement-detail-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .page-header {
        background: darkgreen;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .page-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }

    .announcement-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .announcement-header {
        padding: 2.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e5e7eb;
    }

    .announcement-title {
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 1.5rem 0;
        line-height: 1.3;
    }

    .announcement-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        align-items: center;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: white;
        border-radius: 50px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .meta-icon {
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-general {
        background: #f3f4f6;
        color: #6b7280;
    }

    .category-academic {
        background: #dbeafe;
        color: #1e40af;
    }

    .category-exam {
        background: #fee2e2;
        color: #dc2626;
    }

    .category-timetable {
        background: #fef3c7;
        color: #92400e;
    }

    .category-memo {
        background: #e9d5ff;
        color: #7c3aed;
    }

    .category-other {
        background: #f0fdf4;
        color: #166534;
    }

    .department-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .announcement-body {
        padding: 2.5rem;
    }

    .announcement-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #374151;
        margin-bottom: 2rem;
    }

    .announcement-content p {
        margin-bottom: 1.5rem;
    }

    .announcement-content h1,
    .announcement-content h2,
    .announcement-content h3,
    .announcement-content h4,
    .announcement-content h5,
    .announcement-content h6 {
        color: #111827;
        font-weight: 600;
        margin: 2rem 0 1rem 0;
    }

    .announcement-content ul,
    .announcement-content ol {
        margin: 1rem 0;
        padding-left: 2rem;
    }

    .announcement-content li {
        margin-bottom: 0.5rem;
    }

    .announcement-content blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #6b7280;
    }

    .attachment-section {
        background: #f8fafc;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 2rem;
        margin: 2rem 0;
        text-align: center;
    }

    .attachment-icon {
        width: 60px;
        height: 60px;
        background: #3b82f6;
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem auto;
    }

    .attachment-info h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.5rem 0;
    }

    .attachment-info p {
        color: #6b7280;
        margin: 0 0 1.5rem 0;
    }

    .download-btn {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
    }

    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -3px rgba(59, 130, 246, 0.4);
    }

    .announcement-footer {
        padding: 2rem 2.5rem;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .footer-info {
        display: flex;
        align-items: center;
        gap: 2rem;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .footer-info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .share-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .share-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .share-btn.facebook {
        background: #1877f2;
        color: white;
    }

    .share-btn.twitter {
        background: #1da1f2;
        color: white;
    }

    .share-btn.whatsapp {
        background: #25d366;
        color: white;
    }

    .share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .views-counter {
        background: #e5e7eb;
        color: #374151;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .alert-info {
        background: #005d1d;
        border-left: 4px solid #3b82f6;
        color: #1e40af;
    }

    .alert-warning {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }

    .expiry-notice {
        background: #978f8f;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .announcement-detail-wrapper {
            padding: 0 0.5rem;
        }
        
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .announcement-header {
            padding: 1.5rem;
        }
        
        .announcement-title {
            font-size: 1.5rem;
        }
        
        .announcement-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .announcement-body {
            padding: 1.5rem;
        }
        
        .announcement-footer {
            padding: 1.5rem;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .footer-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>

<div class="announcement-detail-container">
    <div class="announcement-detail-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0; color: #fff;">
                        <i class="fas fa-bullhorn"></i>
                        Announcement Details
                    </h1>
                </div>
                <a href="{{ route('student.announcements') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Announcements
                </a>
            </div>
        </div>

        <!-- Expiry Notice -->
        @if($announcement->expiry_date && $announcement->expiry_date->isToday())
            <div class="expiry-notice">
                <i class="fas fa-exclamation-triangle"></i>
                <span>This announcement expires today!</span>
            </div>
        @elseif($announcement->expiry_date && $announcement->expiry_date->isTomorrow())
            <div class="expiry-notice">
                <i class="fas fa-clock"></i>
                <span>This announcement expires tomorrow.</span>
            </div>
        @endif

        <!-- Department Info -->
        @if($announcement->is_department_specific)
            <div class="alert alert-info">
                <i class="fas fa-info-circle text-xl"></i>
                <div>
                    <p style="margin: 0; font-weight: 600;">Department-Specific Announcement</p>
                    <p style="margin: 0.25rem 0 0 0;">This announcement is specifically for {{ ucfirst($announcement->target_department) }} department students.</p>
                </div>
            </div>
        @endif

        <!-- Main Announcement Card -->
        <div class="announcement-card">
            <div class="announcement-header">
                <h1 class="announcement-title">{{ $announcement->title }}</h1>
                
                <div class="announcement-meta">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <span>{{ $announcement->user->name ?? 'Admin' }}</span>
                    </div>
                    
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span>{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <span class="category-badge category-{{ $announcement->category }}">
                        <i class="fas fa-tag"></i>
                        {{ $announcement->category_display }}
                    </span>
                    
                    @if($announcement->is_department_specific)
                        <span class="department-badge">
                            <i class="fas fa-building"></i>
                            {{ $announcement->target_department_display }}
                        </span>
                    @else
                        <span class="department-badge" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="fas fa-globe"></i>
                            All Departments
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="announcement-body">
                <div class="announcement-content">
                    {!! nl2br(e($announcement->body)) !!}
                </div>
                
                @if($announcement->attachment)
                    <div class="attachment-section">
                        <div class="attachment-icon">
                            <i class="fas fa-paperclip"></i>
                        </div>
                        <div class="attachment-info">
                            <h3>Attachment Available</h3>
                            <p>{{ $announcement->attachment_filename }}</p>
                            <a href="{{ route('student.announcements.download', $announcement) }}" class="download-btn">
                                <i class="fas fa-download"></i>
                                Download Attachment
                            </a>
                        </div>
                    </div>
                @endif
                
                @if($announcement->expiry_date)
                    <div class="alert alert-warning">
                        <i class="fas fa-calendar-times text-xl"></i>
                        <div>
                            <p style="margin: 0; font-weight: 600;">Expiry Information</p>
                            <p style="margin: 0.25rem 0 0 0;">
                                This announcement expires on {{ $announcement->expiry_date->format('M d, Y') }}
                                ({{ $announcement->expiry_date->diffForHumans() }})
                            </p>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="announcement-footer">
                <div class="footer-info">
                    <div class="footer-info-item">
                        <i class="fas fa-eye"></i>
                        <span>{{ number_format($announcement->views) }} views</span>
                    </div>
                    
                    <div class="footer-info-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $announcement->visibility_display }} visibility</span>
                    </div>
                    
                    @if($announcement->updated_at->ne($announcement->created_at))
                        <div class="footer-info-item">
                            <i class="fas fa-edit"></i>
                            <span>Updated {{ $announcement->updated_at->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="share-section">
                    <span style="font-size: 0.875rem; color: #6b7280; margin-right: 0.5rem;">Share:</span>
                    
                    <button class="share-btn facebook" onclick="shareOnFacebook()" title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    
                    <button class="share-btn twitter" onclick="shareOnTwitter()" title="Share on Twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                    
                    <button class="share-btn whatsapp" onclick="shareOnWhatsApp()" title="Share on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    
                    <button class="share-btn" style="background: #6b7280;" onclick="copyLink()" title="Copy Link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Share functionality
    function shareOnFacebook() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ $announcement->title }}');
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    }

    function shareOnTwitter() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ $announcement->title }}');
        const text = encodeURIComponent('Check out this announcement: {{ $announcement->title }}');
        window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank', 'width=600,height=400');
    }

    function shareOnWhatsApp() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('Check out this announcement: {{ $announcement->title }} - ' + url);
        window.open(`https://wa.me/?text=${text}`, '_blank');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            // Show success message
            const btn = event.target.closest('.share-btn');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.style.background = '#10b981';
            
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.style.background = '#6b7280';
            }, 2000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            alert('Failed to copy link to clipboard');
        });
    }

    // Print functionality
    function printAnnouncement() {
        window.print();
    }

    // Add print styles
    const printStyles = `
        @media print {
            .page-header, .announcement-footer, .share-section, .back-btn {
                display: none !important;
            }
            .announcement-card {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
            .announcement-detail-container {
                background: white !important;
                padding: 0 !important;
            }
            .announcement-detail-wrapper {
                max-width: none !important;
                padding: 0 !important;
            }
        }
    `;
    
    const styleSheet = document.createElement("style");
    styleSheet.innerText = printStyles;
    document.head.appendChild(styleSheet);
</script>
@endsection