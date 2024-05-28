import PropTypes from "prop-types";

export default function Example({ props, slots }) {
  const { field_image, body, field_tags, comment } = slots;
  console.log("props", props);
  console.log("slots", slots);
  return (
    <>
      <h4>(Loaded via inertia)</h4>
      {field_image}
      {body}
      {field_tags}
      {comment}
    </>
  );
}

Example.propTypes = {
  slots: PropTypes.any,
  props: PropTypes.shape({
    body: PropTypes.string.isRequired,
    field_image: PropTypes.string,
    field_tags: PropTypes.string,
    comment: PropTypes.string,
  }),
};
