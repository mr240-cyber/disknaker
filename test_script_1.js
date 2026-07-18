
                            document.getElementById('searchHistory').addEventListener('keyup', function () {
                                const val = this.value.toLowerCase();
                                const rows = document.querySelectorAll('.history-row');
                                rows.forEach(r => {
                                    const text = r.textContent.toLowerCase();
                                    r.style.display = text.includes(val) ? '' : 'none';
                                });
                            });
                        