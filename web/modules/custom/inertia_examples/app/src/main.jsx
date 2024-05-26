import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import parse from "html-react-parser";
import DrupalApp from "./DrupalApp";

const TestComponent = () => {
  return <h1>Test</h1>;
};

const inertiaApp = createInertiaApp({
  resolve: (name) => {
    console.log(name);
    const pages = import.meta.glob("./Pages/**/*.jsx", { eager: true });
    return pages[`./Pages/${name}.jsx`];
  },
  setup({ el, App, props }) {
    console.log("el", el);
    // console.log("App", App);
    console.log("props", props);
    // props.initialPage.props.node.customProp = () => <h1>Custom prop</h1>;
    // props.initialPage.props.test = TestComponent;
    // Think about some kind of auto-slot trick here...
    // Convert slots back into props maybe?
    createRoot(el).render(<DrupalApp {...props} slots={<TestComponent />} />);
  },
});

console.log("inertiaApp", inertiaApp);
