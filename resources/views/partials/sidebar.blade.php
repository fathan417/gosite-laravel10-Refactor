<div class="sidebar">
    <div class="header">
        <div class="list-item">
            <a href="">
                <img src="./images/shape.png" alt="" class="icon">
                <span class="description-header">GoSite</span>
            </a>
        </div>
        {{-- <div class="illustration">
            <img src="./images/creativity.png" alt="">
        </div> --}}
    </div>

    <div class="main">
        <div class="list-item {{ $sidebar === "Profil" ? 'active' : '' }}" id="profil">
            <a href="">
                <i class="fa-solid fa-user icon" style="color: #ffffff;"></i>
                <span class="description">Profil</span>
            </a>
        </div>
        <div class="list-item {{ $sidebar === "Dashboard" ? 'active' : '' }}" id="dashboard">
            <a href="./dashboard">
                <i class="fa-solid fa-house icon" style="color: #ffffff;"></i>
                <span class="description">Dashboard</span>
            </a>
        </div>
        <div class="list-item {{ $sidebar === "Event" ? 'active' : '' }}" id="event">
            <a href="./event">
                <i class="fa-solid fa-mug-hot icon" style="color: #ffffff;"></i>
                <span class="description">Event</span>
            </a>
        </div>
        <div class="list-item {{ $sidebar === "Microsite" ? 'active' : '' }}" id="microsite">
            <a href="./microsite">
                <i class="fa-solid fa-link icon" style="color: #ffffff;"></i>
                <span class="description">Microsite</span>
            </a>
        </div>
        <div class="list-item {{ $sidebar === "Team" ? 'active' : '' }}" id="team">
            <a href="">
                <i class="fa-solid fa-users icon" style="color: #ffffff;"></i>
                <span class="description">Team</span>
            </a>
        </div>
        <div class="list-item {{ $sidebar === "Files" ? 'active' : '' }}" id="files">
            <a href="">
                <i class="fa-solid fa-folder-open icon" style="color: #ffffff;"></i>
                <span class="description">Files</span>
            </a>
        </div>
        <div class="list-item {{ $sidebar === "Setting" ? 'active' : '' }}" id="setting">
            <a href="">
                <i class="fa-solid fa-gear icon" style="color: #ffffff;"></i>
                <span class="description">Setting</span>
            </a>
        </div>
    </div>
</div>
