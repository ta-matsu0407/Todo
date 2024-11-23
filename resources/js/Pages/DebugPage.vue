<template>
    <div>
      <h1>デバッグページ</h1>
      <p>{{ message }}</p>
    </div>
  </template>

  <script>
  export default {
    props: {
      message: String,
    },
  };
  </script>
