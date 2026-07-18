
        // initial show call is now in DOMContentLoaded below


        // tampilFormCard - show form based on button click
        function tampilFormCard(val) {
            // Hide all forms first
            document.querySelectorAll('.formdata').forEach(f => f.classList.add('hidden'));

            // Hide the service buttons card
            const serviceCard = document.querySelector('#pelayanan > .card:first-child');
            if (serviceCard) serviceCard.classList.add('hidden');

            // Show the selected form
            if (val === 'pelkes') {
                const el = document.getElementById('form_sk_wrapper');
                if (el) el.classList.remove('hidden');
            }
            if (val === 'p2k3') {
                const el = document.getElementById('form_p2k3');
                if (el) el.classList.remove('hidden');
            }
            if (val === 'kk_pak') {
                const el = document.getElementById('form_kk_pak');
                if (el) el.classList.remove('hidden');
            }
            if (val === 'sk_p2k3') {
                const el = document.getElementById('form_sk_p2k3');
                if (el) el.classList.remove('hidden');
            }
            if (val === 'pelkes_full') {
                const el = document.getElementById('form_pelkes_full');
                if (el) {
                    el.classList.remove('hidden');
                    // show inner sections
                    const dataUmum = document.getElementById('data-umum');
                    const uploads = document.getElementById('uploads');
                    if (dataUmum) dataUmum.classList.remove('hidden');
                    if (uploads) uploads.classList.remove('hidden');
                }
            }

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Show service buttons again (back to selection)
        function kembaliKePilihan() {
            // Hide all forms
            document.querySelectorAll('.formdata').forEach(f => f.classList.add('hidden'));
            // Show service buttons card
            const serviceCard = document.querySelector('#pelayanan > .card:first-child');
            if (serviceCard) serviceCard.classList.remove('hidden');
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Legacy tampilForm - kept for compatibility (if dropdown is used elsewhere)
        function tampilForm() {
            const select = document.getElementById('pilihanLayanan');
            if (select) {
                tampilFormCard(select.value);
            }
        }

        // auto-uppercase company name
        document.addEventListener('input', (e) => {
            if (e.target && e.target.id === 'nama-perusahaan') {
                const start = e.target.selectionStart;
                e.target.value = e.target.value.toUpperCase();
                e.target.selectionStart = e.target.selectionEnd = start;
            }
        });

        // file validation: PDF and <= 1MB
        function validateFileInput(input) {
            const errEl = document.getElementById('err-' + input.id.replace('f-', ''));
            if (!errEl) return false;
            errEl.textContent = '';
            if (!input.files || input.files.length === 0) {
                errEl.textContent = 'File belum dipilih.';
                return false;
            }
            const f = input.files[0];
            if (f.type !== 'application/pdf') {
                errEl.textContent = 'File harus berformat PDF.';
                return false;
            }
            if (f.size > 1_048_576) {
                errEl.textContent = 'Ukuran file melebihi 1 MB.';
                return false;
            }
            return true;
        }

        const fileInputs = Array.from(document.querySelectorAll('input[type=file]'));
        fileInputs.forEach(fi => {
            fi.addEventListener('change', () => validateFileInput(fi));
        });

        // collect form data preview
        function collectFormDataForPreview() {
            const data = {};
            data.email = document.getElementById('email').value;
            data.jenis = document.getElementById('jenis').value;
            data.tanggal = document.getElementById('tanggal').value;
            data.nama_perusahaan = document.getElementById('nama-perusahaan').value;
            data.alamat = document.getElementById('alamat').value;
            data.sektor = document.getElementById('sektor').value;
            data.kontak = document.getElementById('kontak').value;
            data.jumlah = {
                wni_laki: Number(document.getElementById('wni-laki').value || 0),
                wni_perempuan: Number(document.getElementById('wni-perempuan').value || 0),
                wna_laki: Number(document.getElementById('wna-laki').value || 0),
                wna_perempuan: Number(document.getElementById('wna-perempuan').value || 0)
            };
            data.dokter = {
                nama: document.getElementById('dokter').value,
                ttl: document.getElementById('ttl').value,
                nomor_skp: document.getElementById('nomor-skp').value,
                masa_skp: document.getElementById('masa-skp').value,
                no_hiperkes: document.getElementById('no-hiperkes').value,
                str: document.getElementById('str').value,
                sip: document.getElementById('sip').value
            };
            data.files = {};
            fileInputs.forEach(inp => {
                if (inp.files && inp.files[0]) data.files[inp.id] = { name: inp.files[0].name, size: inp.files[0].size };
            });
            return data;
        }

        // preview JSON
        document.getElementById('preview').addEventListener('click', () => {
            // quick required checks (basic)
            const requiredIds = ['email', 'jenis', 'tanggal', 'nama-perusahaan', 'alamat', 'sektor', 'kontak', 'dokter', 'ttl', 'nomor-skp', 'masa-skp', 'no-hiperkes', 'str', 'sip'];
            for (const id of requiredIds) {
                const el = document.getElementById(id);
                if (el && !el.value) {
                    alert('Mohon isi field wajib: ' + id); return;
                }
            }
            // files
            for (const inp of fileInputs) {
                if (!validateFileInput(inp)) { alert('Periksa file: ' + inp.id); return; }
            }
            const data = collectFormDataForPreview();
            document.getElementById('json-output').textContent = JSON.stringify(data, null, 2);
            document.getElementById('result').classList.remove('hidden');
            document.getElementById('result').scrollIntoView({ behavior: 'smooth' });
        });

        // download JSON preview
        document.getElementById('download').addEventListener('click', () => {
            const txt = document.getElementById('json-output').textContent;
            const blob = new Blob([txt], { type: 'application/json' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'pengesahan_pengajuan.json';
            a.click();
            URL.revokeObjectURL(a.href);
        });

        // reset
        document.getElementById('reset').addEventListener('click', () => {
            if (confirm('Reset semua isian?')) {
                document.getElementById('form').reset();
                document.getElementById('result').classList.add('hidden');
                document.getElementById('editIdPengesahan').value = ''; // Clear edit ID on reset
            }
        });

        // story mock
        // story mock removed  -  using server-side rendering

        // submitReal (attached to form submit)
        async function submitReal(e) {
            console.log('🚀 submitReal() dipanggil!');
            e.preventDefault();
            const formEl = document.getElementById('form_pelkes');
            console.log('📝 Form element:', formEl);
            const formData = new FormData();

            const editId = document.getElementById('editIdPengesahan').value;
            if (editId) {
                formData.append('id', editId); // Append ID for update
            }

            // simple fields
            formData.append('email', document.getElementById('email').value);
            formData.append('jenis', document.getElementById('jenis').value);
            formData.append('tanggal', document.getElementById('tanggal').value);
            formData.append('nama_perusahaan', document.getElementById('nama-perusahaan').value);
            formData.append('alamat', document.getElementById('alamat').value);
            formData.append('sektor', document.getElementById('sektor').value);
            formData.append('kontak', document.getElementById('kontak').value);

            // jumlah tenaga kerja
            formData.append('wni_laki', document.getElementById('wni-laki').value);
            formData.append('wni_perempuan', document.getElementById('wni-perempuan').value);
            formData.append('wna_laki', document.getElementById('wna-laki').value);
            formData.append('wna_perempuan', document.getElementById('wna-perempuan').value);

            // dokter
            formData.append('dokter_nama', document.getElementById('dokter').value);
            formData.append('dokter_ttl', document.getElementById('ttl').value);
            formData.append('nomor_skp', document.getElementById('nomor-skp').value);
            formData.append('masa_skp', document.getElementById('masa-skp').value);
            formData.append('no_hiperkes', document.getElementById('no-hiperkes').value);
            formData.append('str', document.getElementById('str').value);
            formData.append('sip', document.getElementById('sip').value);

            // files mapping - MUST match input IDs
            const mapFiles = {
                permohonan: 'f-permohonan',
                struktur: 'f-struktur',
                pernyataan: 'f-pernyataan',
                skp: 'f-skp',
                hiperkes_dokter: 'f-hiperkes-dokter',
                hiperkes_paramedis: 'f-hiperkes-paramedis',
                str_dokter: 'f-str-dokter',
                sip_dokter: 'f-sip-dokter',
                sarana: 'f-sarana',
                bpjs_ketenagakerjaan: 'f-bpjs-kt',
                bpjs_kesehatan: 'f-bpjs-kes',
                wlkp: 'f-wlkp'
            };

            // validate files & append
            for (const [field, inputId] of Object.entries(mapFiles)) {
                const inp = document.getElementById(inputId);
                // Only validate and append if a new file is selected
                if (inp && inp.files && inp.files.length > 0) {
                    const ok = validateFileInput(inp);
                    if (!ok) { alert('Periksa file: ' + inputId); return; }
                    formData.append(field, inp.files[0], inp.files[0].name);
                }
            }

            let url = '/submit-pengesahan';
            // Use the already declared editId variable
            if (editId) {
                url = '/update-pengesahan';
                // formData.append('id', editId); // Already appended above
            }

            try {
                console.log('📤 Mengirim ke:', url);
                console.log('📋 FormData fields:', [...formData.keys()]);

                const resp = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // 'Content-Type': 'multipart/form-data', // Do NOT set this manually for FormData, browser does it automatically with boundary
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                console.log('📥 Response status:', resp.status, resp.statusText);

                // Try to parse as JSON, but handle non-JSON responses
                let json;
                const contentType = resp.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    json = await resp.json();
                } else {
                    const text = await resp.text();
                    console.error('❌ Server mengembalikan non-JSON:', text.substring(0, 500));
                    throw new Error('Server error (bukan JSON): ' + text.substring(0, 200));
                }

                console.log('📥 Response data:', json);

                if (!resp.ok) {
                    // Show detailed error from Laravel validation
                    let errorMsg = 'Error ' + resp.status + ': ';
                    if (json.errors) {
                        // Laravel validation errors
                        const allErrors = Object.values(json.errors).flat();
                        errorMsg += allErrors.join('\n• ');
                    } else if (json.message) {
                        errorMsg += json.message;
                    } else {
                        errorMsg += JSON.stringify(json);
                    }
                    throw new Error(errorMsg);
                }

                alert('✅ Terima kasih — ' + (json.message || 'Pengajuan sukses'));
                window.location.reload();
            } catch (err) {
                console.error('❌ Error lengkap:', err);

                // Check if it's a CSRF error (419)
                if (err.message && err.message.includes('419')) {
                    if (confirm('⚠️ Sesi telah kedaluwarsa (CSRF Token Expired).\n\nKlik OK untuk refresh halaman dan coba lagi.\nData formulir Anda mungkin sudah tersimpan - cek dashboard setelah refresh.')) {
                        window.location.reload();
                    }
                    return;
                }

                // Build detailed error message for other errors
                let detailMsg = '❌ GAGAL MENGIRIM FORMULIR\n\n';
                detailMsg += '📍 Endpoint: ' + url + '\n\n';

                if (err.message) {
                    detailMsg += '💬 Pesan Error:\n' + err.message + '\n\n';
                }

                detailMsg += '💡 Tips:\n';
                detailMsg += '• Pastikan semua field wajib terisi\n';
                detailMsg += '• Pastikan file PDF tidak lebih dari 1MB\n';
                detailMsg += '• Coba refresh halaman (Ctrl+F5) jika masalah berlanjut';

                alert(detailMsg);
            }
        }

        // attach submit

        // attach submit
        const formPelkes = document.getElementById('form_pelkes');
        console.log('🔍 Mencari form_pelkes:', formPelkes);
        if (formPelkes) {
            formPelkes.addEventListener('submit', submitReal);
            console.log('✅ Event listener submit terpasang ke form_pelkes');
        } else {
            console.error('❌ form_pelkes TIDAK DITEMUKAN! Form tidak akan bisa submit.');
        }


        // show data-umum & uploads when jenis changes
        document.getElementById('jenis').addEventListener('change', (e) => {
            const show = !!e.target.value;
            document.getElementById('data-umum').classList.toggle('hidden', !show);
            document.getElementById('uploads').classList.toggle('hidden', !show);
        });

        // When page loads, make sure file validation nodes exist (for preview)
        window.addEventListener('DOMContentLoaded', () => {
            // nothing else for no      w
        });

        // editSubmission moved to HEAD for safety

        // Handle logout - simplified
        const userLogoutForm = document.getElementById('userLogoutForm');
        if (userLogoutForm) {
            userLogoutForm.addEventListener('submit', function (e) {
                // Let form submit normally
                return true;
            });
        }
        // Initial Load
        document.addEventListener('DOMContentLoaded', () => {
            showPage('dashboard');
        });

        // Also handle the existing toggle button
        const toggleBtn = document.getElementById('toggleSidebar');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }

        // Add 3D Tilt Effect to Dashboard Cards
        if (window.matchMedia("(min-width: 768px)").matches) {
            document.querySelectorAll('.card, .stat-card, .service-btn').forEach(card => {
                card.classList.add('tilt-card');
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left - (rect.width / 2);
                    const y = e.clientY - rect.top - (rect.height / 2);
                    const multiplier = card.classList.contains('service-btn') ? 10 : 20;
                    card.style.transform = `perspective(1000px) rotateX(${-y/multiplier}deg) rotateY(${x/multiplier}deg) scale3d(1.02, 1.02, 1.02)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
                });
            });
        }
    