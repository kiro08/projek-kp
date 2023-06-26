 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <section>
                        <section class="live-clock">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div id="clock"></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Memasukkan script JavaScript untuk live clock -->
                        <script>
                            function showTime() {
                                var date = new Date(); // Mendapatkan waktu saat ini
                                var hours = date.getHours();
                                var minutes = date.getMinutes();
                                var seconds = date.getSeconds();
                                var ampm = hours >= 12 ? 'PM' : 'AM';

                                hours = hours % 12;
                                hours = hours ? hours : 12; // Mengubah jam 0 menjadi 12

                                hours = addZeroPadding(hours);
                                minutes = addZeroPadding(minutes);
                                seconds = addZeroPadding(seconds);

                                var time = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

                                document.getElementById('clock').innerText = time;
                                setTimeout(showTime, 1000); // Mengupdate waktu setiap detik
                            }

                            function addZeroPadding(num) {
                                return (parseInt(num, 10) < 10 ? '0' : '') + num; // Menambahkan nol di depan angka < 10
                            }

                            // Memanggil fungsi showTime saat halaman dimuat
                            showTime();
                        </script>
                    </section>
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>