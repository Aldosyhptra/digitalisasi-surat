<div class="max-w-4xl mx-auto mb-16">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Pertanyaan Umum (FAQ)</h2>

    <div class="space-y-4">
        @php
            $faqs = [
                ['q'=>'Bagaimana cara mengajukan surat desa?', 'a'=>'Tim customer service kami siap membantu Anda 24/7', 'open'=>true],
                ['q'=>'Bagaimana cara melihat perkembangan surat saya?', 'a'=>'Anda dapat mengecek status melalui menu Riwayat Pengajuan.', 'open'=>false],
                ['q'=>'Data saya salah setelah diajukan ke admin, bisa diubah?', 'a'=>'Silakan hubungi admin melalui fitur Chat atau Email untuk perbaikan.', 'open'=>false],
                ['q'=>'Sistem error saat membuka form, bagaimana solusinya?', 'a'=>'Pastikan koneksi internet stabil, refresh halaman atau hubungi admin.', 'open'=>false],
                ['q'=>'Butuh Bantuan?', 'a'=>'Tim support siap membantu via WhatsApp, Email, atau datang ke Kantor Desa.', 'open'=>false],
            ];
        @endphp

        @foreach($faqs as $faq)
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 faq-card">
            <button class="flex justify-between items-center w-full text-left font-semibold text-gray-800 focus:outline-none faq-toggle">
                <span>{{ $faq['q'] }}</span>
                <span class="flex items-center justify-center w-8 h-8 rounded-full border border-gray-300 transition-colors duration-200 faq-icon {{ $faq['open'] ? 'bg-blue-600 text-white border-blue-600' : '' }}">
                    <i class="fas {{ $faq['open'] ? 'fa-chevron-down' : 'fa-chevron-right' }} transition-transform duration-200"></i>
                </span>
            </button>
            <div class="faq-content mt-2 text-gray-600 text-sm overflow-hidden transition-max-height duration-300 ease-in-out {{ $faq['open'] ? '' : 'max-h-0' }}">
                <div class="p-1">
                    {{ $faq['a'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const toggles = document.querySelectorAll('.faq-toggle');
    toggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const contentWrapper = btn.nextElementSibling;
            const iconWrapper = btn.querySelector('.faq-icon');
            const icon = iconWrapper.querySelector('i');

            // Toggle icon direction
            icon.classList.toggle('fa-chevron-right');
            icon.classList.toggle('fa-chevron-down');

            // Toggle circle color saat klik
            iconWrapper.classList.toggle('bg-blue-600');
            iconWrapper.classList.toggle('text-white');
            iconWrapper.classList.toggle('border-blue-600');

            // Smooth toggle height
            if(contentWrapper.style.maxHeight){
                contentWrapper.style.maxHeight = null;
            } else {
                contentWrapper.style.maxHeight = contentWrapper.scrollHeight + "px";
            }
        });
    });

    // Set initial max-height untuk yang open
    document.querySelectorAll('.faq-content').forEach(content => {
        if(!content.classList.contains('max-h-0')){
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
});
</script>

<style>
.faq-content {
    max-height: 0;
}

.faq-card {
    border-radius: 0.75rem;
}

/* Hover ringan hanya untuk lingkaran icon */
.faq-icon:hover {
    border-color: #2563EB;
}
</style>
