{{-- loading ball --}}
{{-- <template x-if="isLoadingTable">
  <div class="d-flex justify-content-center bg-white align-items-center   rounded animation__opacity" style="height: 100px">
    <div class="loader">
      <li class="ball"></li>
      <li class="ball"></li>
      <li class="ball"></li>
    </div>
  </div>
</template> --}}

{{-- loading skeleton --}}
<div x-show="isLoadingTable" x-transition>
  <div class="d-flex flex-column gap-2 ">
    <template x-for="j in 25">
      <div class="d-flex gap-2 placeholder-glow">
        <template x-for="i in 10">
          <div class="placeholder" style="width: 100%">lorem</div>
        </template>
      </div>
    </template>
  </div>
</div>
