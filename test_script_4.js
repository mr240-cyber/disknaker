
                        document.getElementById('sk_jenis').addEventListener('change', function (e) {
                            const val = e.target.value;
                            document.getElementById('div_sk_lama').classList.toggle('hidden', val !== 'perubahan');
                        });

                        async function handleSkP2k3Submit(e) {
                            e.preventDefault();
                            if (!confirm('Apakah data sudah benar?')) return;

                            const fd = new FormData();
                            fd.append('jenis', document.getElementById('sk_jenis').value);
                            fd.append('nama_perusahaan', document.getElementById('sk_nama_perusahaan').value);
                            fd.append('alamat', document.getElementById('sk_alamat').value);
                            fd.append('sektor', document.getElementById('sk_sektor').value);
                            fd.append('jumlah_tk', document.getElementById('sk_tk_laki').value); // Controller expects jumlah_tk
                            fd.append('tk_perempuan', document.getElementById('sk_tk_perempuan').value); // We will update controller to read this
                            fd.append('ahli_k3', document.getElementById('sk_ahli_k3').value);
                            fd.append('kontak', document.getElementById('sk_kontak').value);

                            // Files
                            const appendFile = (id, key) => {
                                const el = document.getElementById(id);
                                if (el && el.files[0]) fd.append(key, el.files[0]);
                            };

                            appendFile('sk_file_lama', 'dokumen'); // Controller maps 'dokumen' to f_sk_lama
                            appendFile('sk_file_permohonan', 'f_surat_permohonan');
                            appendFile('sk_file_sertifikat', 'f_sertifikat_ahli_k3');
                            appendFile('sk_file_tambahan', 'f_sertifikat_tambahan');
                            appendFile('sk_file_bpjs_tk', 'f_bpjs_kt');
                            appendFile('sk_file_bpjs_kes', 'f_bpjs_kes');
                            appendFile('sk_file_wlkp', 'f_wlkp');

                            try {
                                const resp = await fetch('/submit-p2k3', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    },
                                    body: fd
                                });
                                const json = await resp.json();
                                if (!resp.ok) throw json;
                                alert('Berhasil: ' + (json.message || 'Pengajuan terkirim'));
                                window.location.reload();
                            } catch (err) {
                                console.error(err);
                                alert('Gagal: ' + (err.message || JSON.stringify(err)));
                            }
                        }
                    