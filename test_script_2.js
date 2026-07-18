
                    (function () {
                        const root = document.getElementById('form_kk_pak');
                        if (!root) return;
                        const q = sel => root.querySelector(sel);
                        const qa = sel => Array.from(root.querySelectorAll(sel));

                        const jenisEls = qa('input[name="jenisPelaporan"]');
                        const sectionKK = q('#sectionKK');
                        const sectionPAK = q('#sectionPAK');
                        const otherSource = q('#otherSourceText');
                        const otherType = q('#otherTypeText');
                        const otherCondition = q('#otherConditionText');
                        const otherAction = q('#otherActionText');

                        const reportFile = q('#reportFile');
                        const fileInfo = q('#fileInfo');
                        const fileErr = q('#fileErr');

                        const pakReportFile = q('#pakReportFile');
                        const pakFileInfo = q('#pakFileInfo');
                        const pakFileErr = q('#pakFileErr');

                        const previewBtn = q('#previewBtn');
                        const previewArea = q('#previewArea');
                        const formEl = q('#laporForm');
                        const formMsg = q('#formMsg');

                        function toggleSections() {
                            const val = root.querySelector('input[name="jenisPelaporan"]:checked').value;
                            if (val === 'kk') {
                                sectionKK.classList.remove('hidden');
                                sectionPAK.classList.add('hidden');
                            } else {
                                sectionKK.classList.add('hidden');
                                sectionPAK.classList.remove('hidden');
                            }
                        }
                        jenisEls.forEach(el => el.addEventListener('change', toggleSections));
                        toggleSections();

                        // show other text when 'other' checked
                        const otherCb = qa('input[type=checkbox][value="otherSource"], input[type=checkbox][value="otherType"], input[type=checkbox][value="otherCondition"], input[type=checkbox][value="otherAction"]');
                        otherCb.forEach(cb => cb.addEventListener('change', e => {
                            const v = e.target.value;
                            if (v === 'otherSource') otherSource.classList.toggle('hidden', !e.target.checked);
                            if (v === 'otherType') otherType.classList.toggle('hidden', !e.target.checked);
                            if (v === 'otherCondition') otherCondition.classList.toggle('hidden', !e.target.checked);
                            if (v === 'otherAction') otherAction.classList.toggle('hidden', !e.target.checked);
                        }));

                        // file validation helper
                        function handleFileInput(inputEl, infoEl, errEl) {
                            if (!infoEl || !errEl) return null;
                            const f = inputEl.files[0];
                            infoEl.classList.remove('hidden');
                            if (!f) { infoEl.textContent = 'Belum ada file.'; errEl.classList.add('hidden'); return null }
                            if (f.type !== 'application/pdf') {
                                errEl.textContent = 'Tipe file tidak didukung. Harap unggah file PDF.'; errEl.classList.remove('hidden'); infoEl.textContent = 'File error'; return null;
                            }
                            const maxBytes = 1 * 1024 * 1024; // 1 MB
                            if (f.size > maxBytes) {
                                errEl.textContent = 'Ukuran file melebihi 1 MB.'; errEl.classList.remove('hidden'); infoEl.textContent = 'File error'; return null;
                            }
                            errEl.classList.add('hidden');
                            infoEl.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                            return f;
                        }

                        if (reportFile) reportFile.addEventListener('change', () => handleFileInput(reportFile, fileInfo, fileErr));
                        if (pakReportFile) pakReportFile.addEventListener('change', () => handleFileInput(pakReportFile, pakFileInfo, pakFileErr));

                        function gatherChecks(name) {
                            return qa('input[type=checkbox][name="' + name + '"]:checked').map(i => i.value);
                        }

                        async function buildPayload() {
                            const payload = {};
                            payload.reporter = {
                                email: (q('#reporterEmail') && q('#reporterEmail').value) || '',
                                name: (q('#reporterName') && q('#reporterName').value) || '',
                                phone: (q('#reporterPhone') && q('#reporterPhone').value) || ''
                            };
                            payload.company = {
                                name: (q('#companyName') && q('#companyName').value) || '',
                                address: (q('#companyAddress') && q('#companyAddress').value) || '',
                                sector: (q('#companySector') && q('#companySector').value) || '',
                                leader: (q('#companyLeader') && q('#companyLeader').value) || '',
                                leaderAddress: (q('#leaderAddress') && q('#leaderAddress').value) || ''
                            };
                            payload.jenisPelaporan = (root.querySelector('input[name="jenisPelaporan"]:checked') || {}).value || '';

                            if (payload.jenisPelaporan === 'kk') {
                                payload.kk = {
                                    victimName: (q('#victimName') && q('#victimName').value) || '',
                                    victimAddress: (q('#victimAddress') && q('#victimAddress').value) || '',
                                    victimBirthplace: (q('#victimBirthplace') && q('#victimBirthplace').value) || '',
                                    victimKpj: (q('#victimKpj') && q('#victimKpj').value) || '',
                                    job: (q('#victimJob') && q('#victimJob').value) || '',
                                    unit: (q('#victimUnit') && q('#victimUnit').value) || '',
                                    wage: (q('#victimWage') && q('#victimWage').value) || '',
                                    accidentPlace: (q('#accidentPlace') && q('#accidentPlace').value) || '',
                                    accidentDate: (q('#accidentDate') && q('#accidentDate').value) || '',
                                    accidentTime: (q('#accidentTime') && q('#accidentTime').value) || '',
                                    accidentDesc: (q('#accidentDesc') && q('#accidentDesc').value) || '',
                                    accidentEffect: (q('#accidentEffect') && q('#accidentEffect').value) || '',
                                    bodyParts: gatherChecks('bodyPart'),
                                    sources: (function () { const s = gatherChecks('source'); if (s.includes('otherSource')) { const t = (q('#otherSourceText') && q('#otherSourceText').value) || ''; if (t) s.push(t); } return s; })(),
                                    types: (function () { const s = gatherChecks('type'); if (s.includes('otherType')) { const t = (q('#otherTypeText') && q('#otherTypeText').value) || ''; if (t) s.push(t); } return s; })(),
                                    conditions: (function () { const s = gatherChecks('condition'); if (s.includes('otherCondition')) { const t = (q('#otherConditionText') && q('#otherConditionText').value) || ''; if (t) s.push(t); } return s; })(),
                                    actions: (function () { const s = gatherChecks('action'); if (s.includes('otherAction')) { const t = (q('#otherActionText') && q('#otherActionText').value) || ''; if (t) s.push(t); } return s; })()
                                };
                                const f = handleFileInput(reportFile, fileInfo, fileErr);
                                if (f) payload.kk.file = { name: f.name, size: f.size, type: f.type };
                            } else {
                                payload.pak = {
                                    victimName: (q('#pakVictimName') && q('#pakVictimName').value) || '',
                                    victimAddress: (q('#pakVictimAddress') && q('#pakVictimAddress').value) || '',
                                    victimBirthplace: (q('#pakBirthplace') && q('#pakBirthplace').value) || '',
                                    victimKpj: (q('#pakKpj') && q('#pakKpj').value) || '',
                                    job: (q('#pakJob') && q('#pakJob').value) || '',
                                    unit: (q('#pakUnit') && q('#pakUnit').value) || '',
                                    wage: (q('#pakWage') && q('#pakWage').value) || '',
                                    diagnosisDate: (q('#pakDiagnosisDate') && q('#pakDiagnosisDate').value) || '',
                                    diagnosis: (q('#pakDiagnosis') && q('#pakDiagnosis').value) || '',
                                    cause: (q('#pakCause') && q('#pakCause').value) || '',
                                    workDesc: (q('#pakWorkDesc') && q('#pakWorkDesc').value) || '',
                                    workHistory: (q('#pakWorkHistory') && q('#pakWorkHistory').value) || '',
                                    doctor: (q('#pakDoctor') && q('#pakDoctor').value) || '',
                                    facility: (q('#pakFacility') && q('#pakFacility').value) || '',
                                    facilityAddress: (q('#pakFacilityAddress') && q('#pakFacilityAddress').value) || ''
                                };
                                const f = handleFileInput(pakReportFile, pakFileInfo, pakFileErr);
                                if (f) payload.pak.file = { name: f.name, size: f.size, type: f.type };
                            }
                            return payload;
                        }

                        function validateRequired() {
                            let ok = true;
                            const requiredIds = ['reporterEmail', 'reporterName', 'reporterPhone', 'companyName', 'companyAddress', 'companySector', 'companyLeader', 'leaderAddress'];
                            requiredIds.forEach(id => {
                                const el = q('#' + id);
                                if (!el) return;
                                if (!el.value || el.value.trim() === '') { el.style.borderColor = '#b91c1c'; ok = false } else { el.style.borderColor = '' }
                            });
                            const jenis = (root.querySelector('input[name="jenisPelaporan"]:checked') || {}).value;
                            if (jenis === 'kk') {
                                ['victimName', 'victimAddress', 'victimBirthplace', 'victimKpj', 'victimJob', 'accidentPlace', 'accidentDate', 'accidentTime', 'accidentDesc', 'accidentEffect'].forEach(id => { const el = q('#' + id); if (!el) return; if (!el.value || el.value.trim() === '') { el.style.borderColor = '#b91c1c'; ok = false } else el.style.borderColor = ''; })
                            } else {
                                ['pakVictimName', 'pakVictimAddress', 'pakKpj', 'pakDiagnosisDate', 'pakDiagnosis', 'pakDoctor', 'pakFacility', 'pakFacilityAddress'].forEach(id => { const el = q('#' + id); if (!el) return; if (!el.value || el.value.trim() === '') { el.style.borderColor = '#b91c1c'; ok = false } else el.style.borderColor = ''; })
                            }
                            return ok;
                        }

                        previewBtn.addEventListener('click', async () => {
                            previewArea.classList.add('hidden');
                            if (!validateRequired()) {
                                formMsg.textContent = 'Masih ada kolom wajib yang kosong. Periksa kolom berwarna merah.';
                                formMsg.style.color = '#b91c1c';
                                return;
                            }
                            formMsg.textContent = 'Siap. Menyiapkan pratinjau...'; formMsg.style.color = '';
                            const payload = await buildPayload();
                            previewArea.innerHTML = '<pre style="white-space:pre-wrap;max-height:420px;overflow:auto">' + JSON.stringify(payload, null, 2) + '</pre>';
                            previewArea.classList.remove('hidden');
                            const blob = new Blob([JSON.stringify(payload, null, 2)], { type: 'application/json' });
                            const url = URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            const ts = new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-');
                            a.download = (payload.jenisPelaporan === 'kk' ? 'laporan-KK-' : 'laporan-PAK-') + ts + '.json';
                            a.textContent = 'Unduh JSON laporan';
                            a.className = 'btn';
                            a.style.display = 'inline-block';
                            a.style.marginTop = '10px';
                            const prevLink = previewArea.querySelector('a'); if (prevLink) prevLink.remove();
                            previewArea.appendChild(a);
                            formMsg.textContent = 'Pratinjau siap. Klik "Unduh JSON laporan" untuk menyimpan data. Untuk pengiriman resmi, integrasikan ke backend atau kirim ke BPJS/Dinas melalui prosedur resmi.';
                            formMsg.style.color = 'green';
                        });

                        // reset handlers to clear preview
                        formEl.addEventListener('reset', () => {
                            setTimeout(() => {
                                previewArea.classList.add('hidden');
                                if (fileInfo) fileInfo.textContent = 'Belum ada file.';
                                if (pakFileInfo) pakFileInfo.textContent = 'Belum ada file.';
                                if (fileErr) fileErr.classList.add('hidden');
                                if (pakFileErr) pakFileErr.classList.add('hidden');
                                qa('input').forEach(i => { try { i.style.borderColor = ''; } catch (e) { } });
                            }, 50);
                        });

                        // prevent actual submit (default behavior)
                        formEl.addEventListener('submit', e => { e.preventDefault(); });

                        // REAL SUBMIT TO SERVER
                        async function submitReport() {
                            if (!validateRequired()) {
                                formMsg.textContent = 'Masih ada kolom wajib yang kosong. Periksa kolom berwarna merah.';
                                formMsg.style.color = '#b91c1c';
                                return;
                            }
                            if (!confirm('Kirim laporan ke database?')) return;

                            const fd = new FormData();
                            // Common fields
                            const getVal = (id) => (document.getElementById(id) ? document.getElementById(id).value : '');

                            // Map to Controller Expectation (KKPAKController)
                            // Controller expects: jenis, nama_pekerja, alamat, pekerjaan, uraian, dokumen (file)
                            // Plus: kpj, unit, upah, tgl_lahir in 'catatan' field or separate if schema supports.
                            // Schema 'pelaporan_kk_pak': nama_perusahaan, alamat_perusahaan, nama_korban, jabatan_korban, jenis_kecelakaan, kronologi, tanggal_kejadian, file_bukti, catatan

                            const jenis = root.querySelector('input[name="jenisPelaporan"]:checked').value;
                            fd.append('jenis', jenis); // 'kk' or 'pak'

                            // Reporter & Company Info (shared)
                            fd.append('nama_perusahaan', getVal('companyName'));
                            fd.append('alamat', getVal('companyAddress'));

                            if (jenis === 'kk') {
                                fd.append('nama_pekerja', getVal('victimName'));
                                fd.append('pekerjaan', getVal('victimJob')); // maps to jabatan_korban
                                fd.append('uraian', getVal('accidentDesc')); // maps to kronologi
                                fd.append('tanggal_kejadian', getVal('accidentDate')); // schema has nullable date

                                // Extra info for 'catatan'
                                fd.append('kpj', getVal('victimKpj'));
                                fd.append('unit', getVal('victimUnit'));
                                fd.append('upah', getVal('victimWage'));
                                fd.append('tgl_lahir', getVal('victimBirthplace'));

                                // File
                                const f = reportFile.files[0];
                                if (f) fd.append('dokumen', f);

                            } else {
                                // PAK
                                fd.append('nama_pekerja', getVal('pakVictimName'));
                                fd.append('pekerjaan', getVal('pakJob'));
                                fd.append('uraian', getVal('pakCause')); // kronologi = cause ? or workDesc? Controller uses 'uraian' -> kronologi

                                // Extra info
                                fd.append('kpj', getVal('pakKpj'));
                                fd.append('unit', getVal('pakUnit'));
                                fd.append('upah', getVal('pakWage'));
                                fd.append('tgl_lahir', getVal('pakBirthplace'));

                                const f = pakReportFile.files[0];
                                if (f) fd.append('dokumen', f);
                            }

                            try {
                                const resp = await fetch('/submit-kkpak', {
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
                                window.location.reload();
                            } catch (err) {
                                console.error(err);
                                alert('Gagal: ' + (err.message || JSON.stringify(err)));
                            }
                        }

                        // Add a button for Real Submit if not exists or replace the Preview logic? 
                        // The user UI has "Pratinjau & Simpan (Unduh JSON)". 
                        // Let's add a separate "Kirim ke Database" button next to "Preview" or change the logic.
                        // I will add a new button dynamically for clarity.
                        const btnArea = root.querySelector('.flex-buttons');
                        const sendBtn = document.createElement('button');
                        sendBtn.type = 'button';
                        sendBtn.className = 'btn-primary'; // assume btn-primary exists or btn
                        sendBtn.textContent = 'Kirim Laporan (Database)';
                        sendBtn.style.marginLeft = '10px';
                        sendBtn.style.backgroundColor = '#0c2c66';
                        sendBtn.style.color = 'white';
                        sendBtn.onclick = submitReport;

                        // Check if already added to avoid dupes on re-run (though this is page load script)
                        if (!btnArea.querySelector('button[data-real-submit]')) {
                            sendBtn.setAttribute('data-real-submit', 'true');
                            btnArea.insertBefore(sendBtn, btnArea.firstChild);
                        }
                    })();
                