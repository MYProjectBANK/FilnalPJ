export const imageUrl = (path) => {
  if (!path) return "/no-image.jpg";
  if (/^https?:\/\//i.test(path)) return path;

  const clean = String(path).replace(/^\/+/, "");
  if (clean.startsWith("storage/")) return `/${clean}`;

  return `/storage/${clean}`;
};
