import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import parse from "html-react-parser";
import DrupalApp from "./DrupalApp";

const inertiaApp = createInertiaApp({
  resolve: (name) => {
    console.log(name);
    const pages = import.meta.glob("./Pages/**/*.jsx", { eager: true });
    return pages[`./Pages/${name}.jsx`];
  },
  setup({ el, props }) {
    const slots = el.querySelectorAll("template");
    const processedSlots = {};
    slots.forEach((element) => {
      const name = element.getAttribute("name");
      processedSlots[name] = parse(element.innerHTML);
    });
    createRoot(el).render(<DrupalApp {...props} slots={processedSlots} />);
  },
});

console.log("inertiaApp", inertiaApp);
