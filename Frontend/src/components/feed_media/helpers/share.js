export const share = ({title, text, url}) => {
    const shared = {
        title: `${title}`,
        text: `${text}`,
        url: `http://${window.location.host}/${url}`
      };
    navigator.share(shared)
}