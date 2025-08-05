<!-- Card Content -->
<div class="container mt-5 text-light">
  <div class="row">
    @foreach($paginated as $e)
      <div class="col-12 col-sm-6 col-md-4 mb-3">
        <div class="Cards card h-100 shadow border-0 card-content p-4 d-flex flex-column justify-content-between">
          <div class="text-center mb-2 h-100">
            <h5 class="font-weight-bold mb-1 card-title-content" data-original="{{ $e->judul }}">
              {{ $e->judul }}
            </h5>
            <p class="small mb-2">{{ $e->tempat }}</p>
          </div>

          @if (!empty($e->jenis_nama) && is_array($e->jenis_nama))
            <div class="mb-3">
              @foreach ($e->jenis_nama as $kategori)
                <span class="badge badge-pill Badges mr-1">{{ $kategori }}</span>
              @endforeach
            </div>
          @endif

          @php
            $start = \Carbon\Carbon::parse($e->waktu_mulai);
            $end = \Carbon\Carbon::parse($e->waktu_selesai);

            $startDate = $start->translatedFormat('d M Y');
            $startTime = $start->format('H:i');
            $endDate = $end->translatedFormat('d M Y');
            $endTime = $end->format('H:i');

            if ($start->toDateString() === $end->toDateString()) {
                $display = "$startDate, $startTime – $endTime";
            } else {
                $display = "$startDate, $startTime – $endDate, $endTime";
            }
          @endphp
          
          <div class="d-flex justify-content-between align-items-center text-light small mt-auto">
            <div
              class="text-truncate mr-3"
              style="min-width: 0; max-width: 100%;"
              title="{{ $display }}"
              data-toggle="tooltip"
              data-placement="top"
            >
              <i class="fa fa-calendar mr-2"></i> {{ $display }}
            </div>
          
            <div class="d-flex flex-shrink-0">
              <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle Button mr-2"
              data-toggle="modal" data-target="#modal_link_{{ $e->id }}" title="Salin Link Presensi">
                <i class="fa fa-link"></i>
              </button>
              <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3"
                data-toggle="modal" data-target="#modal_card_{{ $e->id }}">
                <i class="fa-solid fa-angle-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Presensi Link -->
        <div class="modal fade" id="modal_link_{{ $e->id }}" role="dialog" tabindex="-1" aria-labelledby="modalLinkLabel_{{ $e->id }}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="myModal modal-content text-light border-0 shadow-lg d-flex justify-content-center align-items-center" style="height: 200px;">

              <!-- Modal Header -->
              <div class="modal-header border-0 pb-1 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-light" id="modalLinkLabel_{{ $e->id }}">
                  <i class="fa fa-link mr-2 text-primary"></i> Link Presensi
                </h5>
              </div>

              <!-- Modal Body -->
              <div class="modal-body pt-0 d-flex justify-content-center align-items-center w-75">
                <div class="input-group rounded overflow-hidden shadow-sm">
                  <input type="text"
                         class="form-control bg-dark text-light border-0"
                         id="presensiLinkInput_{{ $e->id }}"
                         value="{{ route('presensi.form', ['token' => $e->token_link]) }}"
                         readonly>

                  <div class="input-group-append">
                    <button class="btn btn-outline-light"
                            type="button"
                            onclick="copyToClipboard('{{ $e->id }}')">
                      <i class="fa fa-copy"></i>
                    </button>
                  </div>
                </div>
              </div>    
            </div>
          </div>
        </div>
    @endforeach
  </div>
</div>

<!-- Modal Cards -->
@foreach($paginated as $e)
  <div class="modal fade" id="modal_card_{{ $e->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel_{{ $e->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content text-light" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border-radius: 20px; border: 1px solid rgba(190, 190, 190, 0.52); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);">

        <!-- Modal Header -->
        <div class="modal-header border-0 d-flex justify-content-center align-items-center bg-transparent">
          <!-- Icon & Title -->
          <img src="{{ asset('images/cards-icon.png') }}" alt="Icon" style="width: 160px; height: 160px;">
          <h5 class="modal-title text-light font-weight-semibold" id="modalLabel_{{ $e->id }}">{{ $e->judul }}</h5>
        </div>

        <!-- Modal Body -->
        <div class="modal-body px-4">
          {{-- Tombol Presensi --}}
          <div class="text-center mb-4">
            <a href="{{ route('presensi.show', ['id' => $e->id]) }}"
               class="btn btn-glass text-light btn-block d-flex align-items-center justify-content-center p-3">
              <i class="fa fa-calendar-check mr-2"></i> Presensi
            </a>
          </div>

          {{-- Daftar Konten --}}
          @foreach($e->contents as $content)
            @if ($content->linkstat === 'show')
              <div class="mb-3">
                <a href="{{ $content->link }}" target="_blank"
                   class="btn btn-glass text-light btn-block d-flex align-items-center justify-content-center p-3">
                  <i class="fa fa-folder mr-2"></i> {{ $content->name }}
                </a>
              </div>
            @endif
          @endforeach
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer border-0 justify-content-center">
          <button type="button" class="btn btn-outline-light rounded-pill px-4" data-dismiss="modal">Tutup</button>
        </div>

      </div>
    </div>
  </div>
@endforeach


<!-- Pagination -->
<nav aria-label="Page navigation" class="mt-auto d-flex justify-content-center pt-2">
  <ul class="pagination">

    {{-- Previous Page Link --}}
    @if ($paginated->onFirstPage())
      <li class="page-item disabled">
        <span class="Page page-link text-light" style="background-color: oklch(27.441% 0.013 253.041);">&laquo;</span>
      </li>
    @else
      <li class="page-item">
        <a class="Page page-link text-light" href="{{ $paginated->previousPageUrl() }}" aria-label="Previous">
          &laquo;
        </a>
      </li>
    @endif

    @for ($i = 1; $i <= $paginated->lastPage(); $i++)
      <li class="page-item">
        <a class="page-link {{ $i == $paginated->currentPage() ? 'Page-active text-light' : 'Page text-light' }}" 
           href="{{ $paginated->url($i) }}">
           {{ $i }}
        </a>
      </li>
    @endfor


    {{-- Next Page Link --}}
    @if ($paginated->hasMorePages())
      <li class="page-item">
        <a class="Page page-link text-light" href="{{ $paginated->nextPageUrl() }}" aria-label="Next">
          &raquo;
        </a>
      </li>
    @else
      <li class="page-item disabled">
        <span class="Page page-link text-light" style="background-color: oklch(27.441% 0.013 253.041);">&raquo;</span>
      </li>
    @endif

  </ul>
</nav>
