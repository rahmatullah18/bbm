<style>
  .scanner span {
    color: transparent;
    position: relative;
    overflow: hidden;
  }

  .scanner span::before {
    content: "Loading...";
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    border-right: 4px solid #17FEFF;
    overflow: hidden;
    color: white;
    animation: load91371 2s linear infinite;
  }

  @keyframes load91371 {

    0%,
    10%,
    100% {
      width: 0;
    }

    10%,
    20%,
    30%,
    40%,
    50%,
    60%,
    70%,
    80%,
    90%,
    100% {
      border-right-color: transparent;
    }

    11%,
    21%,
    31%,
    41%,
    51%,
    61%,
    71%,
    81%,
    91% {
      border-right-color: #17FEFF;
    }

    60%,
    80% {
      width: 100%;
    }
  }

</style>
<button class="btn btn-sm btn-primary" style="padding: 4px 10px" type="button" disabled>
  <div class="loader">
    <div class="scanner">
      <span>Loading...</span>
    </div>
  </div>
</button>
