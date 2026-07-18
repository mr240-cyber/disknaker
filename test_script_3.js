
                        // helper selectors
                        const jenis = document.getElementById('p2k3_jenis');
                        const sectionP2k3 = document.getElementById('p2k3_section');
                        const sectionPelkes = document.getElementById('pelkes_section');
                        const form = document.getElementById('form_p2k3_short');

                        // toggle sections by jenis
                        jenis.addEventListener('change', () => {
                            sectionP2k3.classList.toggle('hidden', jenis.value !== 'p2k3');
                            sectionPelkes.classList.toggle('hidden', jenis.value !== 'pelkes');
                        });

                        // show sub-type when 'sendiri' selected
                        Array.from(document.getElementsByName('pelkes_bentuk')).forEach(r => {
                            r.addEventListener('change', () => {
                                const el = document.getElementById('pelkes_sendiri_type');
                                el.classList.toggle('hidden', document.querySelector('input[name="pelkes_bentuk"]:checked')?.value !== 'sendiri');
                            });
                        });

                        // uppercase company name
                        document.getElementById('p2k3_nama').addEventListener('input', (e) => {
                            const s = e.target.selectionStart;
                            e.target.value = e.target.value.toUpperCase();
                            e.target.selectionStart = e.target.selectionEnd = s;
                        });

                        // file size validation (max 10 MB)
                        function validateFileMax10MB(input, errId) {
                            const errEl = document.getElementById(errId);
                            errEl.textContent = '';
                            if (!input.files || input.files.length === 0) { errEl.textContent = 'File belum dipilih.'; return false; }
                            const f = input.files[0];
                            if (f.type !== 'application/pdf') { errEl.textContent = 'File harus berformat PDF.'; return false; }
                            if (f.size > 10 * 1024 * 1024) { errEl.textContent = 'Ukuran file melebihi 10 MB.'; return false; }
                            return true;
                        }

                        document.getElementById('p2k3_file_report').addEventListener('change', () => validateFileMax10MB(document.getElementById('p2k3_file_report'), 'p2k3_err_file'));
                        document.getElementById('pelkes_file_report').addEventListener('change', () => validateFileMax10MB(document.getElementById('pelkes_file_report'), 'pelkes_err_file'));

                        // Preview JSON
                        document.getElementById('p2k3_preview').addEventListener('click', () => {
                            // basic required checks
                            const required = ['p2k3_email', 'p2k3_nama', 'p2k3_alamat', 'p2k3_sektor', 'p2k3_pimpinan', 'p2k3_jabatan', 'p2k3_tahun', 'p2k3_tanggal', 'p2k3_jenis'];
                            for (const id of required) {
                                const el = document.getElementById(id);
                                if (el && !el.value) { alert('Mohon isi field wajib: ' + id); return; }
                            }
                            const kind = jenis.value;
                            if (kind === 'p2k3') {
                                if (!validateFileMax10MB(document.getElementById('p2k3_file_report'), 'p2k3_err_file')) { alert('Periksa file laporan P2K3'); return; }
                            } else if (kind === 'pelkes') {
                                if (!validateFileMax10MB(document.getElementById('pelkes_file_report'), 'pelkes_err_file')) { alert('Periksa file laporan Pelayanan Kesehatan Kerja'); return; }
                            } else { alert('Pilih jenis laporan'); return; }

                            // collect minimal preview data
                            const data = {
                                email: document.getElementById('p2k3_email').value,
                                perusahaan: document.getElementById('p2k3_nama').value,
                                tahun: document.getElementById('p2k3_tahun').value,
                                tanggal_pelaporan: document.getElementById('p2k3_tanggal').value,
                                jenis_laporan: jenis.value,
                                jumlah_tenaga_kerja: {
                                    wni_laki: Number(document.getElementById('p2k3_wni_laki').value || 0),
                                    wni_perempuan: Number(document.getElementById('p2k3_wni_perempuan').value || 0),
                                    wna_laki: Number(document.getElementById('p2k3_wna_laki').value || 0),
                                    wna_perempuan: Number(document.getElementById('p2k3_wna_perempuan').value || 0)
                                }
                            };
                            if (kind === 'p2k3') {
                                data.p2k3 = {
                                    triwulan: document.getElementById('p2k3_triwulan').value,
                                    ketua: document.getElementById('p2k3_ketua').value,
                                    sekretaris: document.getElementById('p2k3_sekretaris').value,
                                    nomor_sk: document.getElementById('p2k3_nomorsk').value,
                                    hambatan: document.getElementById('p2k3_hambatan').value
                                };
                                const f = document.getElementById('p2k3_file_report').files[0];
                                if (f) data.p2k3.file = { name: f.name, size: f.size };
                            } else {
                                data.pelkes = {
                                    triwulan: document.getElementById('pelkes_triwulan').value,
                                    dokter: document.getElementById('pelkes_dokter').value,
                                    jumlah_dokter: Number(document.getElementById('pelkes_jumlah_dokter').value || 0)
                                };
                                const f = document.getElementById('pelkes_file_report').files[0];
                                if (f) data.pelkes.file = { name: f.name, size: f.size };
                            }

                            document.getElementById('p2k3_json').textContent = JSON.stringify(data, null, 2);
                            document.getElementById('p2k3_result').classList.remove('hidden');
                            document.getElementById('p2k3_result').scrollIntoView({ behavior: 'smooth' });
                        });

                        // simple submit handler (demo)
                        // simple submit handler (updated to Real Submit)
                        form.addEventListener('submit', async (e) => {
                            e.preventDefault();

                            // final validation
                            let isValid = true;
                            if (jenis.value === 'p2k3') {
                                if (!validateFileMax10MB(document.getElementById('p2k3_file_report'), 'p2k3_err_file')) isValid = false;
                            } else if (jenis.value === 'pelkes') {
                                if (!validateFileMax10MB(document.getElementById('pelkes_file_report'), 'pelkes_err_file')) isValid = false;
                            } else {
                                alert('Pilih jenis laporan'); return;
                            }
                            if (!isValid) return;

                            if (!confirm('Kirim Laporan P2K3 ke Dinas?')) return;

                            const fd = new FormData();
                            // Collect all inputs automatically
                            // This is a short-cut to collect p2k3_ data
                            form.querySelectorAll('input, select, textarea').forEach(el => {
                                if (el.id && el.type !== 'file' && el.type !== 'radio' && el.type !== 'checkbox') {
                                    fd.append(el.id, el.value);
                                }
                                if (el.type === 'radio' && el.checked) {
                                    fd.append(el.name, el.value);
                                }
                                if (el.type === 'checkbox' && el.checked) {
                                    fd.append(el.name, el.value); // handles array if name has []
                                }
                            });

                            // Files
                            if (jenis.value === 'p2k3') {
                                const f = document.getElementById('p2k3_file_report').files[0];
                                if (f) fd.append('dokumen', f);
                            } else {
                                const f = document.getElementById('pelkes_file_report').files[0];
                                if (f) fd.append('dokumen', f);
                            }

                            try {
                                const resp = await fetch('/submit-pelaporan-p2k3', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    },
                                    body: fd
                                });

                                if (resp.status === 419) {
                                    alert('⏳ Sesi Anda telah berakhir. Silakan refresh halaman dan login kembali.');
                                    window.location.reload();
                                    return;
                                }

                                const json = await resp.json();
                                if (!resp.ok) throw json;
                                alert('Sukses: ' + (json.message || 'Laporan terkirim'));
                                // optional reset
                                window.location.reload();
                            } catch (err) {
                                console.error(err);
                                alert('Gagal: ' + (err.message || JSON.stringify(err)));
                            }
                        });

                        // reset form
                        document.getElementById('p2k3_reset').addEventListener('click', () => {
                            if (confirm('Reset semua isian?')) {
                                form.reset();
                                sectionP2k3.classList.add('hidden');
                                sectionPelkes.classList.add('hidden');
                                document.getElementById('p2k3_result').classList.add('hidden');
                                document.getElementById('p2k3_err_file').textContent = '';
                                document.getElementById('pelkes_err_file').textContent = '';
                            }
                        });
                    