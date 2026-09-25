<footer class="bg-gray-900 text-gray-300 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Tentang -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 text-white mb-6">
                    <img src="<?= base_url('assets/images/logo.png') ?>" class="w-10 h-10 object-contain">
                    <span class="font-bold text-2xl">SMA Negeri 1 Semarang</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Menghasilkan lulusan yang cerdas, kompetitif di era global, dan tetap menjunjung tinggi kearifan lokal.
                </p>
            </div>

            <!-- Link Cepat -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-6">Jelajahi</h3>
                <ul class="space-y-3 text-sm">
                    <!-- li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary"></i> Sejarah Sekolah</a></li-->
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary"></i> Direktori Guru & Staf</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary"></i> Galeri Kegiatan</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary"></i> Download Area</a></li>
                     <li><a href="login" class="hover:text-secondary transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary"></i> Admin Page (Debug)</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-6">Hubungi Kami</h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-primary"></i>
                        <span>Taman Menteri Supeno No. 1<br>Kota Semarang, Jawa Tengah 50243</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone-alt text-primary"></i>
                        <span>(024) 8310447</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-primary"></i>
                        <span>info@sman1-smg.sch.id</span>
                    </li>
                </ul>
            </div>

            <!-- Sosmed -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-6">Media Sosial</h3>
                <div class="flex space-x-4">
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/sman1semarang/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 hover:text-white transition shadow-lg" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    
                    <!-- YouTube -->
                    <a href="https://www.youtube.com/@officialsman1semarang682" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-lg" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    
                    <!-- Twitter / X -->
                    <a href="http://twitter.com/smansa" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 hover:text-white transition shadow-lg" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/officialsmansasemarang/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-lg" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; <?= date('Y') ?> SMA Negeri 1 Semarang. All rights reserved.</p>
            <p class="mt-2 md:mt-0">Dibuat di Semarang</p>
        </div>
    </div>
</footer>