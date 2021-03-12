<template>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark main-nav">
    <div class="nav flex-fill col-4">
        <img id="img-brand" src="/storage/favicon.jpg" alt="brand" title="Brand">
        <span id="titleApp">Xterminator</span>
    </div>
    <div class="nav flex-fill col-7">
        <div>
            <select class="form-control" name="enviromentSelected" id="enviromentSelected">
                <option value="127.0.0.1" selected>Local - 127.0.0.1</option>
                <option value="192.168.1.15">Warroom15 - 192.168.1.15</option>
                <option value="192.168.1.184">Alípio - 192.168.1.184</option>
                <option value="192.168.1.172">Lucas - 192.168.1.172</option>
            </select>
        </div>
    </div>
    <div class="nav flex-fill col-1">
        <span id="versionApp">V1.0.0</span>
    </div>
</nav>
</template>

<script>
    export default {
        name: 'Navbar'
    }
</script>

<style scoped>
#img-brand {
    height: 50px;
    width: 50px;
    border-radius: 50%;
    margin-right: 5px;
}
#titleApp {
    font-size: 32px;
    font-weight: bold;
    color: white;
    font-family: "Times New Roman", Times, serif;
}
#versionApp {
    font-size: 16px;
    font-weight: bold;
    color: white;
    font-family: "Times New Roman", Times, serif;
}
.fontVersion {
    font-size: 16px;
    font-weight: bold;
    color: white;
}
</style>
