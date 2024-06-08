import PropTypes from "prop-types";

export default function Example({ node }) {
  console.log(node);
  return (
    <div>
      <h4>Loaded via inertia</h4>
      <div dangerouslySetInnerHTML={{ __html: node.body }} />
    </div>
  );
}

Example.propTypes = {
  node: PropTypes.shape({
    body: PropTypes.string.isRequired,
  }),
};
