import PropTypes from "prop-types";

export default function Example({ props, slots }) {
  const { field_image, body, field_tags } = slots;
  console.log("props", props);
  console.log("slots", slots);
  return (
    <>
      <h4>(Loaded via inertia)</h4>
      {/* Iterate over slots object */}
      {Object.keys(slots).map((key) => (
        <div key={key}>{slots[key]}</div>
      ))}
      {/* Access slots directly */}
      {/* {field_image}
      {body}
      {field_tags} */}
    </>
  );
}

Example.propTypes = {
  slots: PropTypes.any,
  props: PropTypes.shape({
    body: PropTypes.string.isRequired,
    field_image: PropTypes.string,
    field_tags: PropTypes.string,
  }),
};
