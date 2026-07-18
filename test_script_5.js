
                    function openReceiptModal(type, url) {
                        document.getElementById('modal_form_step').classList.remove('hide-modal');
                        document.getElementById('modal_success_step').classList.add('hide-modal');
                        document.getElementById('modal_receipt_form').reset();
                        document.getElementById('active_doc_url').value = url;
                        if (type === 'sk_p2k3') document.getElementById('radio_sk_p2k3').checked = true;
                        if (type === 'sk_pelkes') document.getElementById('radio_sk_pelkes').checked = true;

                        document.getElementById('receiptModal').style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    }

                    function closeReceiptModal() {
                        document.getElementById('receiptModal').style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }

                    function handleReceiptSubmit(e) {
                        e.preventDefault();
                        const url = document.getElementById('active_doc_url').value;
                        const label = document.querySelector('input[name="modal_dokumen"]:checked').parentElement.querySelector('span').innerText.trim();

                        document.getElementById('modal_form_step').classList.add('hide-modal');
                        document.getElementById('modal_success_step').classList.remove('hide-modal');

                        const container = document.getElementById('revealed_link_container_ultra');
                        container.innerHTML = `
                            <div class="link-box-ultra">
                                <div style="text-align:left;">
                                    <div style="font-size:11px; color:#198754; text-transform:uppercase; font-weight:800; letter-spacing:1px; margin-bottom:5px;">Dokumen Siap</div>
                                    <div style="font-weight:800; font-size:18px; color:#1e293b;">${label}</div>
                                </div>
                                <a href="${url}" id="auto_download_link" class="btn-dl-ultra">
                                    <i class="fas fa-cloud-download-alt"></i> Unduh Berkas
                                </a>
                            </div>
                        `;

                        // Automatically trigger download
                        setTimeout(() => {
                            const link = document.getElementById('auto_download_link');
                            if (link) link.click();
                        }, 500);
                    }

                    window.addEventListener('click', (e) => {
                        if (e.target === document.getElementById('receiptModal')) closeReceiptModal();
                    });
                