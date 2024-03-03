/**
 * Realiza una llamada a la API de Art Institute of Chicago para obtener información sobre todas las piezas de arte.
 * @date 2/22/2024 - 3:13:34 PM
 * @author Aaron Medina Rodriguez
 *
 * @export
 * @async
 * @returns {Object} Un objeto que contiene información sobre todas las piezas de arte.
 */
export async function apiArtworks() {
  try {
    const response = await fetch(
      `https://api.artic.edu/api/v1/artworks?fields=id,title,artist_title,date_display,image_id,thumbnail&limit=20`
    );
    const data = await response.json();

    const artistNamesSet = new Set();
    data.data.forEach((artwork) => {
      if (artwork.artist_title) {
        artistNamesSet.add(artwork.artist_title);
      }
    });

    const artistNames = Array.from(artistNamesSet);
    const filteredData = {
      artist: artistNames,
      data: data.data.filter((artwork) => artwork.image_id !== null),
    };
    console.log(filteredData);
    return filteredData;
  } catch (error) {
    console.error(error);
  }
}

/**
 * Realiza una llamada a la API de Art Institute of Chicago para obtener información paginada sobre todas las piezas de arte.
 * @date 2/22/2024 - 3:13:34 PM
 * @author Aaron Medina Rodriguez
 *
 * @export
 * @async
 * @returns {Object} Un objeto que contiene información sobre todas las piezas de arte de un artista.
 */
export async function apiArtworksArtist() {
  try {
    const url =
      "https://api.artic.edu/api/v1/artworks/search?q=ClaudeMonet&fields=id,title,artist_title,date_display,image_id,thumbnail&limit=20";
    const response = await fetch(url);
    const data = await response.json();

    const filteredData = {
      artist: data.data[0].artist_title,
      data: data.data.filter((artwork) => artwork.image_id !== null),
    };

    return filteredData;
  } catch (error) {
    console.error(error);
  }
}

/**
 * Realiza una llamada a la API de Art Institute of Chicago para obtener información sobre una pieza de arte aleatoria.
 * @date 2/22/2024 - 3:13:34 PM
 * @author Aaron Medina Rodriguez
 *
 * @exports
 * @async
 * @returns {Object} Un objeto que contiene información sobre todas las piezas de arte aleatoria.
 */
export async function apiArtworksRandom() {
  let validArtwork = null;

  while (!validArtwork) {
    const number = Math.round(Math.random() * 130000);
    console.log(number);
    const url = `https://api.artic.edu/api/v1/artworks/${number}?fields=id,title,artist_title,date_display,image_id,thumbnail&limit=20`;

    try {
      const response = await fetch(url);

      if (response.ok) {
        const data = await response.json();

        if (data.data && data.data.id && data.data.image_id) {
          validArtwork = data.data;
        }
      }
    } catch (error) {
      //console.error(error);
    }

    if (!validArtwork) {
      await new Promise((resolve) => setTimeout(resolve, 100));
    }
  }

  return validArtwork;
}
