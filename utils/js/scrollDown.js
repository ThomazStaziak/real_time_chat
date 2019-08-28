const scrollDown = (id, multiplier) => {
  $(id).animate({
    scrollTop: $(document).height() * multiplier
  });
};
