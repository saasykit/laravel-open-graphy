<style>

    /*Reset*/
    *, *::before, *::after {
        box-sizing: border-box;
    }
    * {
        margin: 0;
    }
    body {
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }
    img, picture, video, canvas, svg {
        display: block;
        max-width: 100%;
    }
    input, button, textarea, select {
        font: inherit;
    }
    p, h1, h2, h3, h4, h5, h6 {
        overflow-wrap: break-word;
    }
    #root, #__next {
        isolation: isolate;
    }

    /*Custom*/

    body {
        width: {{ config('open_graph_image.width') }}px;
        height: {{ config('open_graph_image.height') }}px;
        color: white;
        display: flex;
        justify-content: center;
    }

    .headline {
        font-family: "Poetsen One", sans-serif;
        font-weight: 400;
        font-style: normal;

        font-size: 48px;
        color: white;
        text-shadow: 0 2px 0 #000, 0 4px 6px rgba(0, 0, 0, .8);
        line-height: 1.2;
    }

    .logo {
        height: 40px;
        max-width: fit-content;
    }

    .headline-container {
        width: 50%;
        display: flex;
        padding: 15px;
    }

    .flex-column {
        flex-direction: column;
        justify-items: center;
        gap: 20px;
    }

    .flex-row {
        flex-direction: row;
        justify-items: center;
        align-items: center;
    }

    .headline-container.full-width {
        width: 100% !important;
    }

    .top-container {
        display: flex;
        gap: 20px;
        justify-items: center;
        align-items: center;
        margin: 0 auto;
        padding: 60px 40px;
        position: relative;
    }

    .image-container {
        margin-right: 35px;
        display: flex;
        justify-items: center;
        align-items: center;
        text-align: end;
        width: 50%;
    }

    .image {
        border-radius: 1rem;
        width: 100%;
        max-height: 420px;

        object-fit: cover;
        object-position: top;
        border: 4px solid white;
        transform: perspective(705px) rotateY(-24deg);
        box-shadow: rgba(0, 0, 0, .7) 20px 30px 90px;
    }

</style>
