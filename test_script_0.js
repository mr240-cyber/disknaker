
        // --- CORE NAVIGATION (Moved to Head for Safety) ---
        function showPage(pageId) {
            // Hide all pages
            document.querySelectorAll('.page').forEach(p => {
                p.classList.remove('active');
                p.classList.add('hidden');
            });

            // Show target
            const el = document.getElementById(pageId);
            if (el) {
                el.classList.remove('hidden');
                el.classList.add('active');
            }

            // Close sidebar on mobile
            const sidebar = document.querySelector('aside');
            const overlay = document.querySelector('.overlay');
            if (sidebar && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
            if (overlay && overlay.classList.contains('active')) {
                overlay.classList.remove('active');
            }
            window.scrollTo(0, 0);
        }

        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            const overlay = document.querySelector('.overlay');
            if (sidebar) sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
        }
        async function editSubmission(type, id) {
            try {
                // Ensure page is ready
                const pelSection = document.getElementById('pelayanan');
                if (!pelSection) {
                    alert('Halaman tidak siap. Silakan refresh.');
                    return;
                }

                alert("⏳ Sedang mengambil data pengajuan...");
                let res = await fetch(`/user/submission/${type}/${id}`);
                if (!res.ok) throw new Error("Gagal mengambil data.");
                let data = await res.json();

                // Helper function
                const setVal = (id, val) => {
                    const el = document.getElementById(id);
                    if (el && val !== null && val !== undefined) el.value = val;
                };

                if (type === 'pelayanan_kesekerja') {
                    // 1. Show Form
                    showPage('pelayanan'); // Use the helper
                    document.getElementById('pilihanLayanan').value = 'pelkes_full';

                    // Call user-defined 'tampilForm' if available, otherwise manual
                    if (typeof tampilForm === 'function') {
                        tampilForm();
                    } else {
                        // Fallback manual show
                        document.querySelectorAll('.formdata').forEach(f => f.classList.add('hidden'));
                        document.getElementById('form_pelkes_full').classList.remove('hidden');
                        document.getElementById('data-umum').classList.remove('hidden');
                        document.getElementById('uploads').classList.remove('hidden');
                    }

                    // 2. Fill Data
                    setVal('editIdPengesahan', data.id); // Important: ID for Update
                    setVal('email', data.email);
                    setVal('jenis', data.jenis_pengajuan);

                    // Trigger change logic for jenis
                    const jenisEl = document.getElementById('jenis');
                    if (jenisEl) jenisEl.dispatchEvent(new Event('change'));

                    setVal('tanggal', data.tanggal_pengusulan);
                    setVal('nama-perusahaan', data.nama_perusahaan);
                    setVal('alamat', data.alamat_perusahaan);
                    setVal('sektor', data.sektor);

                    // Tenaga Kerja
                    setVal('wni-laki', data.tk_wni_laki || 0);
                    setVal('wni-perempuan', data.tk_wni_perempuan || 0);
                    setVal('wna-laki', data.tk_wna_laki || 0);
                    setVal('wna-perempuan', data.tk_wna_perempuan || 0);

                    // Dokter
                    setVal('dokter', data.nama_dokter);
                    setVal('ttl', data.ttl_dokter);
                    setVal('nomor-skp', data.nomor_skp_dokter);
                    setVal('masa-skp', data.masa_berlaku_skp);
                    setVal('no-hiperkes', data.nomor_hiperkes);
                    setVal('str', data.nomor_str);
                    setVal('sip', data.nomor_sip);
                    setVal('kontak', data.kontak);

                    alert("✅ Formulir telah diisi dengan data sebelumnya. Silakan perbaiki bagian yang salah dan upload ulang file jika diperlukan.");
                    window.scrollTo(0, 0);
                }                // Handle SK P2K3 edit
                else if (type === 'sk_p2k3') {
                    // 1. Show Form SK P2K3
                    showPage('pelayanan');

                    // Show the SK P2K3 form (form_sk_wrapper)
                    if (typeof tampilFormCard === 'function') {
                        tampilFormCard('pelkes'); // 'pelkes' maps to form_sk_wrapper
                    } else {
                        document.querySelectorAll('.formdata').forEach(f => f.classList.add('hidden'));
                        const formWrapper = document.getElementById('form_sk_wrapper');
                        if (formWrapper) formWrapper.classList.remove('hidden');
                    }

                    // 2. Fill Data
                    // Store edit ID for update
                    let editIdField = document.getElementById('editIdSkP2k3');
                    if (!editIdField) {
                        // Create hidden input for edit ID
                        const form = document.getElementById('real_form_sk_p2k3');
                        if (form) {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.id = 'editIdSkP2k3';
                            hiddenInput.name = 'edit_id';
                            hiddenInput.value = data.id;
                            form.appendChild(hiddenInput);
                        }
                    } else {
                        editIdField.value = data.id;
                    }

                    // Fill form fields
                    setVal('sk_jenis', data.jenis || data.jenis_pengajuan);
                    setVal('sk_nama_perusahaan', data.nama_perusahaan);
                    setVal('sk_alamat', data.alamat);
                    setVal('sk_sektor', data.sektor);
                    setVal('sk_tk_laki', data.jumlah_tk || 0);
                    setVal('sk_tk_perempuan', data.tk_perempuan || 0);
                    setVal('sk_ahli_k3', data.ahli_k3);
                    setVal('sk_kontak', data.kontak);

                    // Trigger jenis change to show/hide SK lama field
                    const skJenisEl = document.getElementById('sk_jenis');
                    if (skJenisEl) skJenisEl.dispatchEvent(new Event('change'));

                    alert("✅ Formulir SK P2K3 telah diisi dengan data sebelumnya.\n\nSilakan perbaiki bagian yang salah dan upload ulang file jika diperlukan.");
                    window.scrollTo(0, 0);
                }
                // Handle other types (P2K3 pelaporan, KK/PAK)
                else if (type === 'pelaporan_p2k3') {
                    showPage('pelayanan');
                    if (typeof tampilFormCard === 'function') {
                        tampilFormCard('p2k3');
                    } else {
                        document.querySelectorAll('.formdata').forEach(f => f.classList.add('hidden'));
                        const formP2k3 = document.getElementById('form_p2k3');
                        if (formP2k3) formP2k3.classList.remove('hidden');
                    }

                    // Store edit ID
                    let editIdField = document.getElementById('p2k3_editId');
                    if (!editIdField) {
                        const form = document.getElementById('form_p2k3_short');
                        if (form) {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.id = 'p2k3_editId';
                            hiddenInput.name = 'edit_id';
                            hiddenInput.value = data.id;
                            form.appendChild(hiddenInput);
                        }
                    } else {
                        editIdField.value = data.id;
                    }

                    // Fill form fields with correct IDs from form_p2k3_short
                    setVal('p2k3_email', data.email);
                    setVal('p2k3_nama', data.nama_perusahaan);
                    setVal('p2k3_alamat', data.alamat || data.alamat_perusahaan);
                    setVal('p2k3_sektor', data.sektor);
                    setVal('p2k3_pimpinan', data.nama_pimpinan);
                    setVal('p2k3_jabatan', data.jabatan_pimpinan);
                    setVal('p2k3_wni_laki', data.tk_wni_laki || 0);
                    setVal('p2k3_wni_perempuan', data.tk_wni_perempuan || 0);
                    setVal('p2k3_wna_laki', data.tk_wna_laki || 0);
                    setVal('p2k3_wna_perempuan', data.tk_wna_perempuan || 0);
                    setVal('p2k3_tahun', data.tahun_pelaporan);
                    setVal('p2k3_tanggal', data.tanggal_pelaporan);

                    alert("✅ Formulir Pelaporan P2K3 telah diisi dengan data sebelumnya.\n\nSilakan perbaiki bagian yang salah dan upload ulang file jika diperlukan.");
                    window.scrollTo(0, 0);
                }
                else if (type === 'pelaporan_kk_pak') {
                    showPage('pelayanan');
                    if (typeof tampilFormCard === 'function') {
                        tampilFormCard('kk_pak');
                    } else {
                        document.querySelectorAll('.formdata').forEach(f => f.classList.add('hidden'));
                        const formKkPak = document.getElementById('form_kk_pak');
                        if (formKkPak) formKkPak.classList.remove('hidden');
                    }

                    // Store edit ID
                    let editIdField = document.getElementById('kkpak_editId');
                    if (!editIdField) {
                        const form = document.getElementById('laporForm');
                        if (form) {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.id = 'kkpak_editId';
                            hiddenInput.name = 'edit_id';
                            hiddenInput.value = data.id;
                            form.appendChild(hiddenInput);
                        }
                    } else {
                        editIdField.value = data.id;
                    }

                    // Fill form fields with correct IDs from laporForm
                    setVal('reporterEmail', data.email);
                    setVal('reporterName', data.nama_pelapor);
                    setVal('reporterPhone', data.no_hp_pelapor);
                    setVal('companyName', data.nama_perusahaan);
                    setVal('companyAddress', data.alamat_perusahaan);
                    setVal('companySector', data.sektor);
                    setVal('companyLeader', data.nama_pimpinan);
                    setVal('leaderAddress', data.alamat_pimpinan);

                    // Set radio button for jenis pelaporan
                    if (data.jenis_pelaporan === 'kk' || data.jenis_pelaporan === 'Kecelakaan Kerja') {
                        const radioKk = document.querySelector('input[name="jenisPelaporan"][value="kk"]');
                        if (radioKk) radioKk.checked = true;
                    } else if (data.jenis_pelaporan === 'pak' || data.jenis_pelaporan === 'Penyakit Akibat Kerja') {
                        const radioPak = document.querySelector('input[name="jenisPelaporan"][value="pak"]');
                        if (radioPak) radioPak.checked = true;
                    }

                    alert("✅ Formulir Pelaporan KK/PAK telah diisi dengan data sebelumnya.\n\nSilakan perbaiki bagian yang salah dan upload ulang file jika diperlukan.");
                    window.scrollTo(0, 0);
                }
                else {
                    alert("⚠️ Fitur edit untuk layanan tipe ini belum tersedia.\n\nSilakan hubungi admin atau ajukan pengajuan baru.");
                }
            } catch (e) {
                console.error(e);
                alert("❌ Error: " + e.message);
            }
        }
        async function showDetailSubmission(type, id) {
            try {
                alert("⏳ Mengambil data...");
                let res = await fetch(`/user/submission/${type}/${id}`);
                if (!res.ok) throw new Error("Gagal mengambil data.");
                let data = await res.json();

                let info = `DETAIL PENGAJUAN #${data.id}\n`;
                info += `---------------------------\n`;
                info += `Perusahaan: ${data.nama_perusahaan}\n`;
                info += `Jenis: ${data.jenis_pengajuan}\n`;
                info += `Tanggal: ${data.tanggal_pengusulan}\n`;
                info += `Status: ${data.status_pengajuan}\n`;
                if (data.catatan) info += `Catatan Admin: ${data.catatan}\n`;

                alert(info);
            } catch (e) {
                alert("Gagal melihat detail: " + e.message);
            }
        }
    