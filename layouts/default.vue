<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
      <div class="collapse navbar-collapse mx-3" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active fw-bold">
            <NuxtLink to="/" class="nav-link">Home</NuxtLink>
          </li>
          <li class="nav-item fw-bold">
            <NuxtLink to="/upload" class="nav-link">Upload</NuxtLink>
          </li>
        </ul>
      </div>
    </nav>
    <div class="d-flex align-items-center justify-content-center" style="height: 90vh;">
      <slot />
    </div>
  </div>
</template>