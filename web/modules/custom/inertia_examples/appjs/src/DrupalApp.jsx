import { createHeadManager, router } from "@inertiajs/core";
import {
  createElement,
  useEffect,
  useMemo,
  useState,
  createContext,
} from "react";
import PropTypes from "prop-types";

const HeadContext = createContext(undefined);
HeadContext.displayName = "InertiaHeadContext";

const PageContext = createContext(undefined);
PageContext.displayName = "InertiaPageContext";

export default function DrupalApp({
  children,
  initialPage,
  initialComponent,
  resolveComponent,
  titleCallback,
  onHeadUpdate,
  slots,
}) {
  console.log("slots", slots);
  console.log("initialPage", initialPage);
  console.log("initialComponent", initialComponent);
  const [current, setCurrent] = useState({
    component: initialComponent || null,
    page: initialPage,
    key: null,
  });

  const headManager = useMemo(() => {
    return createHeadManager(
      typeof window === "undefined",
      titleCallback || ((title) => title),
      onHeadUpdate || (() => {})
    );
  }, []);

  useEffect(() => {
    router.init({
      initialPage,
      resolveComponent,
      swapComponent: async ({ component, page, preserveState }) => {
        setCurrent((current) => ({
          component,
          page,
          key: preserveState ? current.key : Date.now(),
        }));
      },
    });

    router.on("navigate", () => headManager.forceUpdate());
  }, []);

  if (!current.component) {
    return createElement(
      HeadContext.Provider,
      { value: headManager },
      createElement(PageContext.Provider, { value: current.page }, null)
    );
  }

  const renderChildren =
    children ||
    (({ Component, props, slots, key }) => {
      const child = createElement(Component, { key, ...props, slots });

      if (typeof Component.layout === "function") {
        return Component.layout(child);
      }

      if (Array.isArray(Component.layout)) {
        return Component.layout
          .concat(child)
          .reverse()
          .reduce((children, Layout) =>
            createElement(Layout, { children, ...props })
          );
      }

      return child;
    });

  return createElement(
    HeadContext.Provider,
    { value: headManager },
    createElement(
      PageContext.Provider,
      { value: current.page },
      renderChildren({
        Component: current.component,
        key: current.key,
        props: current.page.props,
        slots: slots,
      })
    )
  );
}

DrupalApp.displayName = "Inertia";

DrupalApp.propTypes = {
  children: PropTypes.any,
  initialPage: PropTypes.any,
  initialComponent: PropTypes.any,
  resolveComponent: PropTypes.func,
  titleCallback: PropTypes.func,
  onHeadUpdate: PropTypes.func,
  slots: PropTypes.any,
};
