export const share = ({title, text, url}) => {
    const shared = {
        title: `${title}`,
        text: `${text}`,
        url: `https://localhost:5173/${url}`
      };
    navigator.share(shared)
}